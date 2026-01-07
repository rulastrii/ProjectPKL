<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaProfile;
use App\Models\Presensi;
use App\Models\Aktivitas;
use Carbon\Carbon;

class PresensiMagangController extends Controller
{
    /**
     * Tampilkan daftar presensi magang
     * (TIDAK DIUBAH LOGIKA)
     */
    public function index(Request $request)
{
    $user = auth()->user();

    // ⛔ hanya untuk PKL / Magang
    if (!in_array($user->role_id, [5])) {
        abort(403, 'Akses hanya untuk Mahasiswa Magang.');
    }

    $siswa = SiswaProfile::where('user_id', $user->id)->first();

    // ⛔ profile belum ada atau belum lengkap
    if (!$siswa || !$siswa->isLengkap()) {
        return redirect()
            ->route('magang.profile.index')
            ->with('warning', 'Silakan lengkapi profil terlebih dahulu sebelum melakukan presensi.');
    }

    // ================= QUERY PRESENSI =================

    $query = Presensi::where('siswa_id', $siswa->id);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('siswa', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%")
              ->orWhere('nim', 'like', "%{$search}%");
        });
    }

    if ($request->filled('tanggal')) {
        $query->where('tanggal', $request->tanggal);
    }

    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $perPage  = $request->input('per_page', 10);
    $presensi = $query->orderBy('tanggal', 'desc')->paginate($perPage);
    $presensi->appends($request->all());

    // ================= PRESENSI HARI INI =================

    $todayPresensi = Presensi::where('siswa_id', $siswa->id)
        ->where('tanggal', now()->toDateString())
        ->first();

    return view('magang.presensi.index', compact(
        'siswa',
        'presensi',
        'todayPresensi'
    ));
}


    /**
     * Halaman absensi hari ini
     * (tetap pakai view yang sama → data dibuat konsisten)
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role_id != 5) abort(403);

        $siswa = SiswaProfile::where('user_id', $user->id)->firstOrFail();

        $todayPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', now()->toDateString())
            ->first();

        // supaya blade AMAN
        $presensi = collect();

        return view('magang.presensi.index', compact(
            'siswa',
            'todayPresensi',
            'presensi'
        ));
    }

    /**
     * Simpan absensi masuk / pulang
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role_id != 5) abort(403);

        $siswa   = SiswaProfile::where('user_id', $user->id)->firstOrFail();
        $tanggal = now()->toDateString();
        $now     = Carbon::now('Asia/Jakarta');

        $request->validate([
            'tab'         => 'required|in:masuk,pulang',
            'foto_masuk'  => 'nullable|image|max:2048',
            'foto_pulang' => 'nullable|image|max:2048',
        ]);

        /**
         * ================= ABSEN MASUK =================
         */
        if ($request->tab === 'masuk') {

            if ($now->gt(Carbon::createFromTime(11, 0))) {
                return back()->withErrors([
                    'msg' => 'Absen masuk melewati jam 11.00.'
                ]);
            }

            $presensi = Presensi::firstOrNew([
                'siswa_id' => $siswa->id,
                'tanggal'  => $tanggal
            ]);

            if ($presensi->jam_masuk) {
                return back()->withErrors(['msg' => 'Absensi masuk sudah dilakukan.']);
            }

            $presensi->jam_masuk   = $now->format('H:i:s');
            $presensi->status      = 'hadir';
            $presensi->kelengkapan = 'tidak_lengkap';

            if ($request->hasFile('foto_masuk')) {
                $file = $request->file('foto_masuk');
                $filename = time().'_masuk_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_masuk = $filename;
            }

            $presensi->save();
        }

        /**
         * ================= ABSEN PULANG =================
         */
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

        /**
         * ================= AKTIVITAS =================
         */
        $pembimbing = optional($siswa->pengajuan)->pembimbing?->first();

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
        ]);

        return redirect()
            ->route('magang.presensi.index')
            ->with('success', 'Presensi berhasil disimpan.');
    }
}
