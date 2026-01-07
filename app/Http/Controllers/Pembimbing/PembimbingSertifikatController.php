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
use App\Models\Pembimbing;
use PDF;

class PembimbingSertifikatController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 10;
        $search  = $request->search;

        /** ================= PEMBIMBING LOGIN ================= */
        $pembimbing = Pembimbing::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->whereNull('deleted_date')
            ->firstOrFail();

        /** ================= SERTIFIKAT (HANYA BIMBINGAN) ================= */
        $sertifikat = Sertifikat::with('siswa.user')
            ->whereHas('siswa.pengajuan.pembimbing', function ($q) use ($pembimbing) {
                $q->where('pembimbing.id', $pembimbing->id)
                  ->where('pembimbing.is_active', 1);
            })
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

        /** ================= SISWA TANPA SERTIFIKAT (BIMBINGAN) ================= */
        $siswa = SiswaProfile::whereDoesntHave('sertifikat')
            ->whereHas('pengajuan.pembimbing', function ($q) use ($pembimbing) {
                $q->where('pembimbing.id', $pembimbing->id)
                  ->where('pembimbing.is_active', 1);
            })
            ->orderBy('nama')
            ->get();

        return view('pembimbing.sertifikat.index', compact('sertifikat', 'siswa'));
    }

    public function create()
    {
        $pembimbing = Pembimbing::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->whereNull('deleted_date')
            ->firstOrFail();

        $siswa = SiswaProfile::whereHas('penilaianAkhir', function ($q) {
                $q->whereNotNull('nilai_akhir');
            })
            ->whereDoesntHave('sertifikat')
            ->whereHas('pengajuan.pembimbing', function ($q) use ($pembimbing) {
                $q->where('pembimbing.id', $pembimbing->id)
                  ->where('pembimbing.is_active', 1);
            })
            ->orderBy('nama')
            ->get();

        return view('pembimbing.sertifikat.create', compact('siswa'));
    }

    public function show($id)
    {
        $pembimbing = Pembimbing::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->whereNull('deleted_date')
            ->firstOrFail();

        $sertifikat = Sertifikat::with('siswa.user')
            ->whereHas('siswa.pengajuan.pembimbing', function ($q) use ($pembimbing) {
                $q->where('pembimbing.id', $pembimbing->id);
            })
            ->findOrFail($id);

        return view('pembimbing.sertifikat.show', compact('sertifikat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa_profile,id',
            'judul'    => 'nullable|string|max:255',
        ]);

        /** ================= PEMBIMBING LOGIN ================= */
        $pembimbing = Pembimbing::where('user_id', auth()->id())
            ->where('is_active', 1)
            ->whereNull('deleted_date')
            ->firstOrFail();

        $siswa = SiswaProfile::with(['user', 'pengajuan.pembimbing'])
            ->findOrFail($request->siswa_id);

        /** ================= VALIDASI KEPEMILIKAN ================= */
        $isBimbingan = $siswa->pengajuan
            ? $siswa->pengajuan->pembimbing
                ->where('id', $pembimbing->id)
                ->where('is_active', 1)
                ->count() > 0
            : false;

        if (!$isBimbingan) {
            abort(403, 'Anda tidak berhak menerbitkan sertifikat untuk peserta ini.');
        }

        /** ================= CEGAH DUPLIKASI ================= */
        if (Sertifikat::where('siswa_id', $siswa->id)->exists()) {
            return back()->withErrors([
                'siswa_id' => 'Sertifikat untuk peserta ini sudah diterbitkan.'
            ]);
        }

        $role = $siswa->user->role_id;

        /** ================= AMBIL PENGAJUAN ================= */
        if ($role == 4) {
            // PKL
            $jenis = 'PKL';

            $pengajuanSiswa = PengajuanPklSiswa::where('siswa_id', $siswa->id)
                ->with('pengajuan')
                ->first();

            if (!$pengajuanSiswa || !$pengajuanSiswa->pengajuan) {
                return back()->withErrors([
                    'siswa_id' => 'Data pengajuan PKL belum tersedia.'
                ]);
            }

            $pengajuan = $pengajuanSiswa->pengajuan;

        } elseif ($role == 5) {
            // MAGANG
            $jenis = 'MAGANG';

            $pengajuan = PengajuanMagangMahasiswa::where('user_id', $siswa->user_id)
                ->firstOrFail();
        } else {
            abort(403);
        }

        return DB::transaction(function () use ($request, $siswa, $pengajuan, $jenis) {

            $tahun        = date('Y');
            $kodeInstansi = 'DKIS-KC';

            /** ================= NOMOR SERTIFIKAT ================= */
            $last = Sertifikat::where('nomor_sertifikat', 'like', "%/{$jenis}/%")
                ->whereYear('created_at', $tahun)
                ->latest()
                ->first();

            $urut = $last
                ? str_pad((int) explode('/', $last->nomor_sertifikat)[0] + 1, 3, '0', STR_PAD_LEFT)
                : '001';

            $nomorSertifikat = "{$urut}/{$jenis}/{$kodeInstansi}/{$tahun}";

            /** ================= NOMOR SURAT ================= */
            $lastSurat = Sertifikat::whereYear('created_at', $tahun)->latest()->first();
            $noSurat   = $lastSurat
                ? (int) explode('/', $lastSurat->nomor_surat)[1] + 1
                : 1;

            $nomorSurat = "800/{$noSurat}/DKIS/{$tahun}";

            /** ================= SIMPAN ================= */
            $sertifikat = Sertifikat::create([
                'siswa_id'         => $siswa->id,
                'nomor_sertifikat' => $nomorSertifikat,
                'nomor_surat'      => $nomorSurat,
                'judul'            => $request->judul ?? 'Sertifikat Penyelesaian',
                'periode_mulai'    => $pengajuan->periode_mulai,
                'periode_selesai'  => $pengajuan->periode_selesai,
                'tanggal_terbit'   => now(),
                'qr_token'         => Str::uuid(),
            ]);

            /** ================= GENERATE PDF ================= */
            $pdf = PDF::loadView('sertifikat.pdf', compact('sertifikat'));

            $filename = 'sertifikat_' . $sertifikat->id . '.pdf';
            $path     = 'uploads/sertifikat/' . $filename;

            $pdf->save(public_path($path));

            $sertifikat->update([
                'file_path' => $path
            ]);

            return redirect()
                ->route('pembimbing.sertifikat.index')
                ->with('success', 'Sertifikat berhasil diterbitkan.');
        });
    }
}
