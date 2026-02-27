<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use App\Models\Pembimbing;
use PDF;
    use Illuminate\Http\Request;


class PembimbingRekapController extends Controller
{
/**
 * Rekap semua peserta bimbingan
 */
public function index(Request $request)
{
    $userId  = Auth::id();
    $search  = $request->search;
    $perPage = $request->per_page ?? 10;

    // ambil semua pengajuan yang dibimbing user ini
    $pengajuanIds = Pembimbing::where('user_id', $userId)
        ->where('is_active', 1)
        ->pluck('pengajuan_id');

    $siswaList = SiswaProfile::where(function ($q) use ($pengajuanIds) {
            $q->whereIn('pengajuan_id', $pengajuanIds)
              ->orWhereIn('pengajuanpkl_id', $pengajuanIds);
        })
        ->when($search, function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%");
        })
        ->withCount([
            'presensi as total_hadir' => fn ($q) => $q->where('status', 'hadir'),
            'presensi as total_izin'  => fn ($q) => $q->where('status', 'izin'),
            'presensi as total_sakit' => fn ($q) => $q->where('status', 'sakit'),
            'presensi as total_absen' => fn ($q) => $q->where('status', 'absen'),
            'laporan',
            'tugasSubmit'
        ])
        ->paginate($perPage)
        ->withQueryString();

    return view('pembimbing.rekap.index', compact('siswaList'));
}


    /**
 * Detail rekap per siswa
 */
public function show($id)
{
    $userId = Auth::id();

    // ================= PEMBIMBING LOGIN =================
    $pembimbing = Pembimbing::where('user_id', $userId)
        ->where('is_active', 1)
        ->firstOrFail();

    // ================= AMANKAN: HANYA SISWA BIMBINGAN =================
    $siswa = SiswaProfile::where(function ($q) use ($pembimbing) {
            $q->whereHas('pembimbingMahasiswa', function ($pm) use ($pembimbing) {
                $pm->where('user_id', $pembimbing->user_id);
            })
            ->orWhereHas('pembimbingPkl', function ($pp) use ($pembimbing) {
                $pp->where('user_id', $pembimbing->user_id);
            });
        })
        ->with([
            'presensi',
            'laporan',
            'tugasSubmit.tugas',
            'penilaianAkhir',
            'pembimbingMahasiswa.user',
            'pembimbingPkl.user',
        ])
        ->findOrFail($id);

    // ================= REKAP PRESENSI =================
    $rekapPresensi = [
        'hadir' => $siswa->presensi->where('status', 'hadir')->count(),
        'izin'  => $siswa->presensi->where('status', 'izin')->count(),
        'sakit' => $siswa->presensi->where('status', 'sakit')->count(),
        'absen' => $siswa->presensi->where('status', 'absen')->count(),
    ];

    return view('pembimbing.rekap.show', compact('siswa', 'rekapPresensi'));
}


    /**
     * Cetak PDF rekap siswa
     */
    public function pdf($id)
    {
        $siswa = SiswaProfile::with([
            'presensi',
            'laporan',
            'tugasSubmit.tugas',
            'penilaianAkhir',
            'pembimbingMahasiswa.user',
            'pembimbingPkl.user'
        ])->findOrFail($id);

        $pdf = PDF::loadView('pembimbing.rekap.pdf', compact('siswa'));

        return $pdf->download('rekap-peserta-' . $siswa->nama . '.pdf');
    }
}
