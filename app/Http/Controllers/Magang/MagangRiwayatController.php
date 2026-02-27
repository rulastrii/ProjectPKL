<?php

namespace App\Http\Controllers\Magang;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SiswaProfile;
use Illuminate\Http\Request;

class MagangRiwayatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $siswa = SiswaProfile::with(['pengajuan.penempatan.bidang', 'penilaianAkhir', 'sertifikat'])
            ->where('user_id', $user->id)
            ->first();

        $riwayat = collect();

        if ($siswa && $siswa->pengajuan) {
            $penempatan = $siswa->pengajuan->penempatan;

            $riwayat->push((object)[
                'id' => $siswa->pengajuan->id,
                'instansi' => 'Dinas Komunikasi, Informatika, dan Statistik Kota Cirebon',
                'periode_mulai' => $siswa->pengajuan->periode_mulai,
                'periode_selesai' => $siswa->pengajuan->periode_selesai,
                'posisi' => $penempatan ? $penempatan->bidang->nama : '-',
                'status' => $siswa->pengajuan->status ?? '-',
                'nilai_akhir' => $siswa->penilaianAkhir->nilai_akhir ?? '-',
                'sertifikat' => $siswa->sertifikat,
            ]);
        }

        return view('magang.riwayat.index', compact('riwayat'));
    }

    public function show($id)
    {
        $user = Auth::user();

        $siswa = SiswaProfile::with(['pengajuan.penempatan.bidang', 'penilaianAkhir', 'sertifikat'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        if (!$siswa->pengajuan || $siswa->pengajuan->id != $id) {
            abort(404);
        }

        $penempatan = $siswa->pengajuan->penempatan;

        $riwayat = (object)[
            'id' => $siswa->pengajuan->id,
            'instansi' => 'Dinas Komunikasi, Informatika, dan Statistik Kota Cirebon',
            'periode_mulai' => $siswa->pengajuan->periode_mulai,
            'periode_selesai' => $siswa->pengajuan->periode_selesai,
            'posisi' => $penempatan ? $penempatan->bidang->nama : '-',
            'status' => $siswa->pengajuan->status ?? '-',
            'nilai_akhir' => $siswa->penilaianAkhir->nilai_akhir ?? '-',
            'sertifikat' => $siswa->sertifikat,
        ];

        return view('magang.riwayat.show', compact('riwayat'));
    }
}
