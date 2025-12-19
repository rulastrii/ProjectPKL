<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use App\Models\SiswaProfile;
use Carbon\Carbon;

class PresensiMagangController extends Controller
{
    /**
     * Tampilkan daftar presensi magang
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Pastikan user role magang
        if ($user->role_id != 5) {
            abort(403, 'Akses hanya untuk magang.');
        }

        // Ambil profile magang dari tabel siswa_profile
        $siswa = SiswaProfile::where('user_id', $user->id)->first();
        if (!$siswa) {
            abort(404, 'Profile magang tidak ditemukan.');
        }

        $query = Presensi::where('siswa_id', $siswa->id);

        // Filter search (nama / NISN)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nisn', 'like', "%$search%")
                  ->orWhere('nim', 'like', "%$search%");
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $presensi = $query->orderBy('tanggal', 'desc')->paginate($perPage);
        $presensi->appends($request->all());

        return view('magang.presensi.index', compact('presensi', 'siswa'));
    }

    /**
     * Halaman absensi hari ini
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role_id != 5) {
            abort(403, 'Akses hanya untuk magang.');
        }

        $siswa = SiswaProfile::where('user_id', $user->id)->first();
        if (!$siswa) {
            abort(404, 'Profile magang tidak ditemukan.');
        }

        // Ambil presensi hari ini
        $todayPresensi = Presensi::where('siswa_id', $siswa->id)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        $jamMasuk = $todayPresensi->jam_masuk ?? null;
        $jamPulang = $todayPresensi->jam_keluar ?? null;

        $absenMasukSudah = !is_null($jamMasuk);
        $absenPulangSudah = !is_null($jamPulang);

        return view('magang.presensi.index', compact(
            'siswa', 'todayPresensi', 'jamMasuk', 'jamPulang', 'absenMasukSudah', 'absenPulangSudah'
        ));
    }

    /**
     * Simpan absensi masuk / pulang
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role_id != 5) {
            abort(403, 'Akses hanya untuk magang.');
        }

        $siswa = SiswaProfile::where('user_id', $user->id)->first();
        if (!$siswa) {
            return back()->withErrors(['msg' => 'Profile magang tidak ditemukan.']);
        }

        $tanggal = date('Y-m-d');

        $request->validate([
            'tab' => 'required|in:masuk,pulang',
            'status' => 'required_if:tab,masuk|in:hadir,izin,sakit,absen',
            'foto_masuk' => 'nullable|image|max:2048',
            'foto_pulang' => 'nullable|image|max:2048',
        ]);

        /** ================= ABSEN MASUK ================= */
        if ($request->tab === 'masuk') {

            $presensi = Presensi::firstOrNew([
                'siswa_id' => $siswa->id,
                'tanggal' => $tanggal
            ]);

            if ($presensi->jam_masuk) {
                return back()->withErrors(['msg' => 'Absensi masuk sudah dilakukan.']);
            }

            $presensi->jam_masuk = Carbon::now('Asia/Jakarta')->format('H:i:s');
            $presensi->status = $request->status;

            if ($request->hasFile('foto_masuk')) {
                $file = $request->file('foto_masuk');
                $filename = time().'_masuk_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_masuk = $filename;
            }

            $presensi->save();
        }

        /** ================= ABSEN PULANG ================= */
        if ($request->tab === 'pulang') {

            $presensi = Presensi::where('siswa_id', $siswa->id)
                ->where('tanggal', $tanggal)
                ->first();

            if (!$presensi || !$presensi->jam_masuk) {
                return back()->withErrors(['msg' => 'Anda belum melakukan absensi masuk.']);
            }

            if ($presensi->jam_keluar) {
                return back()->withErrors(['msg' => 'Absensi pulang sudah dilakukan.']);
            }

            $presensi->jam_keluar = Carbon::now('Asia/Jakarta')->format('H:i:s');

            if ($request->hasFile('foto_pulang')) {
                $file = $request->file('foto_pulang');
                $filename = time().'_pulang_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/presensi'), $filename);
                $presensi->foto_pulang = $filename;
            }

            $presensi->save();
        }

        return redirect()->route('magang.presensi.index')
            ->with('success', 'Presensi berhasil disimpan.');
    }
}
