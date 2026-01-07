<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaProfile;
use App\Models\Presensi;
use App\Models\Aktivitas;
use Carbon\Carbon;

class PresensiSiswaController extends Controller
{
    /**
     * Tampilkan daftar presensi siswa PKL
     */
    public function index(Request $request) {
        $user = auth()->user();


        // ⛔ Hanya untuk siswa PKL
        if ($user->role_id != 4) {
            abort(403, 'Akses hanya untuk siswa PKL.');
        }

        // Ambil profile siswa
        $siswa = SiswaProfile::where('user_id', $user->id)->first();

        // ⛔ Profile belum ada atau belum lengkap
        if (!$siswa || !$siswa->isLengkap()) {
            return redirect()
                ->route('siswa.profile.index') // ganti sesuai route profile siswa
                ->with('warning', 'Silakan lengkapi profil terlebih dahulu sebelum melakukan presensi.');
        }

        $query = Presensi::where('siswa_id', $siswa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%");
            });
        }

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $presensi = $query->orderBy('tanggal', 'desc')->paginate($perPage);
        $presensi->appends($request->all());

        return view('siswa.presensi.index', compact('presensi', 'siswa'));
    }

    /**
     * Halaman absensi hari ini
     */
    public function create() {
        $user = auth()->user();
        if ($user->role_id != 4) abort(403);

        $siswa = SiswaProfile::where('user_id', $user->id)->firstOrFail();

        $todayPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        return view('siswa.presensi.index', compact('siswa', 'todayPresensi'));
    }

    /**
     * Simpan absensi masuk / pulang
     */
    public function store(Request $request) {
        $user = auth()->user();
        if ($user->role_id != 4) abort(403);

        $siswa   = SiswaProfile::where('user_id', $user->id)->firstOrFail();
        $tanggal = date('Y-m-d');
        $now     = Carbon::now('Asia/Jakarta');

        $request->validate([
            'tab'         => 'required|in:masuk,pulang',
            'foto_masuk'  => 'nullable|image|max:2048',
            'foto_pulang' => 'nullable|image|max:2048',
        ]);

        // ================= ABSEN MASUK =================
        if ($request->tab === 'masuk') {
            if ($now->gt(Carbon::createFromTime(11, 0))) {
                return back()->withErrors([
                    'msg' => 'Absen masuk melewati jam 11.00, dianggap tidak hadir.'
                ]);
            }

            $presensi = Presensi::firstOrNew([
                'siswa_id' => $siswa->id,
                'tanggal'  => $tanggal
            ]);

            if ($presensi->jam_masuk) {
                return back()->withErrors(['msg' => 'Absensi masuk sudah dilakukan.']);
            }

            $presensi->jam_masuk  = $now->format('H:i:s');
            $presensi->status     = 'hadir';
            $presensi->kelengkapan = 'tidak_lengkap';

            if ($request->hasFile('foto_masuk')) {
                $file = $request->file('foto_masuk');
                $filename = time().'_masuk_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_masuk = $filename;
            }

            $presensi->save();
        }

        // ================= ABSEN PULANG =================
        if ($request->tab === 'pulang') {
            if ($now->gt(Carbon::createFromTime(17, 0))) {
                return back()->withErrors([
                    'msg' => 'Absen pulang melewati jam 17.00.'
                ]);
            }

            $presensi = Presensi::firstOrNew([
                'siswa_id' => $siswa->id,
                'tanggal'  => $tanggal
            ]);

            if ($presensi->jam_keluar) {
                return back()->withErrors(['msg' => 'Absensi pulang sudah dilakukan.']);
            }

            $presensi->jam_keluar = $now->format('H:i:s');

            if ($presensi->jam_masuk) {
                $presensi->status      = $presensi->status ?? 'hadir';
                $presensi->kelengkapan = 'lengkap';
            } else {
                $presensi->status      = 'hadir';
                $presensi->kelengkapan = 'tidak_lengkap';
            }

            if ($request->hasFile('foto_pulang')) {
                $file = $request->file('foto_pulang');
                $filename = time().'_pulang_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_pulang = $filename;
            }

            $presensi->save();
        }

        $pembimbing = optional($siswa->pengajuanpkl?->pembimbing->first());

        $aksi = $request->tab === 'masuk'
            ? 'melakukan presensi masuk'
            : 'melakukan presensi pulang';

        Aktivitas::create([
            'pegawai_id' => $pembimbing?->pegawai_id,
            'siswa_id'   => $siswa->id,
            'nama'       => $siswa->nama,
            'aksi'       => $aksi,
            'sumber'     => 'presensi',
            'ref_id'     => $presensi->id,
            'created_at' => now(),
        ]);

        return redirect()->route('siswa.presensi.index')
            ->with('success', 'Presensi berhasil disimpan.');
    }
}
