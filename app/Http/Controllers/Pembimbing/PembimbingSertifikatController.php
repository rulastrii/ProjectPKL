<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\SiswaProfile;
use App\Models\PengajuanPklSiswa;
use App\Models\PengajuanMagangMahasiswa;
use App\Models\Sertifikat;
use PDF;

class PembimbingSertifikatController extends Controller
{
    public function index(Request $request) {
        $perPage = $request->per_page ?? 10;
        $search  = $request->search;

        $sertifikat = Sertifikat::with('siswa.user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('siswa', function ($qs) use ($search) {
                        $qs->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhere('nomor_sertifikat', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // hanya siswa yang BELUM punya sertifikat
        $siswa = SiswaProfile::whereDoesntHave('sertifikat')
            ->orderBy('nama')
            ->get();

        return view('pembimbing.sertifikat.index', compact('sertifikat', 'siswa'));
    }

    public function create() {
        $siswa = SiswaProfile::whereHas('penilaianAkhir', function ($q) {
                $q->whereNotNull('nilai_akhir');
            })
            ->whereDoesntHave('sertifikat')
            ->orderBy('nama')
            ->get();

        return view('pembimbing.sertifikat.create', compact('siswa'));
    }

    public function show($id) {
        $sertifikat = Sertifikat::with('siswa.user')->findOrFail($id);

        return view('pembimbing.sertifikat.show', compact('sertifikat'));
    }

    public function store(Request $request) {
        $request->validate([
            'siswa_id' => 'required|exists:siswa_profile,id',
            'judul'    => 'nullable|string|max:255',
        ]);

        $siswa = SiswaProfile::with('user')->findOrFail($request->siswa_id);

        /**
         *  CEGAH DUPLIKASI SERTIFIKAT (BACKEND)
         * Walaupun UI sudah disaring
         */
        $alreadyHasCertificate = Sertifikat::where('siswa_id', $siswa->id)->exists();

        if ($alreadyHasCertificate) {
            return redirect()
                ->back()
                ->withErrors([
                    'siswa_id' => 'Sertifikat untuk peserta ini sudah diterbitkan.'
                ])
                ->withInput();
        }

        $role = $siswa->user->role_id;

        /**
         *  Tentukan jenis & pengajuan berdasarkan role
         */
        if ($role == 4) {
    // PKL (SISWA)
    $jenis = 'PKL';

    // Ambil pengajuan siswa, jika ada
    $pengajuanSiswa = PengajuanPklSiswa::where('siswa_id', $siswa->id)
        ->with('pengajuan')
        ->first();

    if (!$pengajuanSiswa || !$pengajuanSiswa->pengajuan) {
        return redirect()->back()->withErrors([
            'siswa_id' => 'Data pengajuan PKL untuk siswa ini belum tersedia.'
        ])->withInput();
    }

    $pengajuan = $pengajuanSiswa->pengajuan;

        } elseif ($role == 5) {
            // MAGANG (MAHASISWA)
            $jenis = 'MAGANG';

            $pengajuan = PengajuanMagangMahasiswa::where('user_id', $siswa->user_id)
                ->firstOrFail();
        } else {
            abort(403);
        }

        return DB::transaction(function () use ($request, $siswa, $pengajuan, $jenis) {

            $tahun         = date('Y');
            $kodeInstansi  = 'DKIS-KC';

            /**
             *  Nomor Sertifikat (urut per jenis per tahun)
             */
            $last = Sertifikat::where('nomor_sertifikat', 'like', "%/{$jenis}/%")
                ->whereYear('created_at', $tahun)
                ->latest()
                ->first();

            $urut = $last
                ? str_pad((int) explode('/', $last->nomor_sertifikat)[0] + 1, 3, '0', STR_PAD_LEFT)
                : '001';

            $nomorSertifikat = "{$urut}/{$jenis}/{$kodeInstansi}/{$tahun}";

            /**
             *  Nomor Surat
             */
            $lastSurat = Sertifikat::whereYear('created_at', $tahun)->latest()->first();
            $noSurat   = $lastSurat
                ? (int) explode('/', $lastSurat->nomor_surat)[1] + 1
                : 1;

            $nomorSurat = "800/{$noSurat}/DKIS/{$tahun}";

            /**
             *  QR Token
             */
            $qrToken = Str::uuid();

            /**
             *  Simpan Sertifikat (tanpa PDF dulu)
             */
            $sertifikat = Sertifikat::create([
                'siswa_id'        => $siswa->id,
                'nomor_sertifikat'=> $nomorSertifikat,
                'nomor_surat'     => $nomorSurat,
                'judul'           => $request->judul ?? 'Sertifikat Penyelesaian',
                'periode_mulai'   => $pengajuan->periode_mulai,
                'periode_selesai' => $pengajuan->periode_selesai,
                'tanggal_terbit'  => now(),
                'qr_token'        => $qrToken,
            ]);

            /**
             *  Generate PDF
             */
            $pdf = PDF::loadView('sertifikat.pdf', compact('sertifikat'));

            $filename = 'sertifikat_' . $sertifikat->id . '.pdf';
            $path     = 'uploads/sertifikat/' . $filename;

            $pdf->save(public_path($path));

            $sertifikat->update([
                'file_path' => $path
            ]);

            return redirect()
                ->route('pembimbing.sertifikat.index')
                ->with('success', 'Sertifikat berhasil diterbitkan');
        });
    }

}