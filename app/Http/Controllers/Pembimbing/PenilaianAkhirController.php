<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiswaProfile;
use App\Models\PenilaianAkhir;

class PenilaianAkhirController extends Controller
{
    public function index(Request $request)
    {
        $search  = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = SiswaProfile::where('is_active', 1)
            ->with([
                'tugasSubmit' => function ($q) {
                    $q->where('status', 'sudah dinilai');
                },
                'laporan',
                'penilaianAkhir',
                'pengajuan.pembimbing'
            ]);

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        $siswaPaginated = $query->paginate($perPage)->withQueryString();

        foreach ($siswaPaginated as $s) {

            /** ================= NILAI ================= */
            $tugasAvg = $s->tugasSubmit->avg('skor') ?? 0;

            $totalLaporan = $s->laporan()->count();
            $laporanTerverifikasi = $s->laporan
                ->where('status_verifikasi', 'terverifikasi')
                ->count();

            $laporanAvg = $totalLaporan > 0
                ? ($laporanTerverifikasi / $totalLaporan) * 100
                : 0;

            $keaktifan = $s->penilaianAkhir->nilai_keaktifan ?? 0;
            $sikap     = $s->penilaianAkhir->nilai_sikap ?? 0;

            /** ================= PEMBIMBING ================= */
            $pembimbing = $s->pengajuan
                ? $s->pengajuan->pembimbing()
                    ->where('is_active', 1)
                    ->first()
                : null;

            $pembimbingId = $pembimbing?->id;

            /** ================= PERIODE ================= */
            $periodeMulai = $s->penilaianAkhir->periode_mulai
    ?? $s->pengajuan?->periode_mulai;

$periodeSelesai = $s->penilaianAkhir->periode_selesai
    ?? $s->pengajuan?->periode_selesai;


            /** ================= SIMPAN ================= */
            if (!$s->penilaianAkhir) {

                $penilaian = new PenilaianAkhir([
                    'periode_mulai'   => $periodeMulai,
                    'periode_selesai' => $periodeSelesai,
                    'nilai_tugas'     => $tugasAvg,
                    'nilai_laporan'   => $laporanAvg,
                    'nilai_keaktifan' => $keaktifan,
                    'nilai_sikap'     => $sikap,
                    'nilai_akhir'     => ($tugasAvg * 0.5)
                                        + ($laporanAvg * 0.3)
                                        + ($keaktifan * 0.1)
                                        + ($sikap * 0.1),
                    'pembimbing_id'   => $pembimbingId,
                ]);

                $s->penilaianAkhir()->save($penilaian);

            } else {

                $s->penilaianAkhir->update([
                    'periode_mulai'   => $periodeMulai,
                    'periode_selesai' => $periodeSelesai,
                    'nilai_tugas'     => $tugasAvg,
                    'nilai_laporan'   => $laporanAvg,
                    'pembimbing_id'   => $pembimbingId,
                ]);

                $s->penilaianAkhir->hitungNilaiAkhir();
            }
        }

        $penilaian = PenilaianAkhir::with('siswa')
            ->whereIn('siswa_id', $siswaPaginated->pluck('id'))
            ->paginate($perPage)
            ->withQueryString();

        return view('pembimbing.penilaian-akhir.index', compact('penilaian'));
    }

    public function edit($id)
    {
        $penilaian = PenilaianAkhir::findOrFail($id);
        return view('pembimbing.penilaian-akhir.edit', compact('penilaian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nilai_keaktifan' => 'required|numeric|min:0|max:100',
            'nilai_sikap'     => 'required|numeric|min:0|max:100',
        ]);

        $penilaian = PenilaianAkhir::with('siswa.sertifikat')->findOrFail($id);

        if ($penilaian->siswa->sertifikat) {
            return redirect()
                ->route('pembimbing.penilaian-akhir.index')
                ->with('error', 'Nilai tidak dapat diubah karena sertifikat sudah diterbitkan.');
        }

        $penilaian->nilai_keaktifan = $request->nilai_keaktifan;
        $penilaian->nilai_sikap     = $request->nilai_sikap;
        $penilaian->hitungNilaiAkhir();

        return redirect()
            ->route('pembimbing.penilaian-akhir.index')
            ->with('success', 'Nilai berhasil diperbarui!');
    }

    public function show($id)
    {
        $penilaian = PenilaianAkhir::with('siswa')->findOrFail($id);
        return view('pembimbing.penilaian-akhir.show', compact('penilaian'));
    }
}
