<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\PenilaianAkhir;
use App\Models\SiswaProfile;
use App\Models\Penempatan;
use App\Models\Pembimbing;
use Illuminate\Http\Request;

class PenilaianAkhirController extends Controller
{
    /**
     * List peserta bimbingan
     */
    public function index()
{
    $pembimbing = Pembimbing::where('user_id', auth()->id())->firstOrFail();

    $siswa = SiswaProfile::whereHas('penempatan.bidang', function ($q) use ($pembimbing) {
        $q->where('id', $pembimbing->bidang_id);
    })
    ->with('penilaianAkhir')
    ->get();

    return view('pembimbing.penilaian_akhir.index', compact('siswa'));
}


    /**
     * Form input / edit nilai akhir
     */
    public function form($siswa_id)
    {
        $siswa = SiswaProfile::findOrFail($siswa_id);

        $penilaian = PenilaianAkhir::firstOrNew([
            'siswa_id' => $siswa->id
        ]);

        return view('pembimbing.penilaian_akhir.form', compact('siswa', 'penilaian'));
    }

    /**
     * Simpan & hitung nilai akhir
     */
    public function store(Request $request, $siswa_id)
    {
        $request->validate([
            'nilai_keaktifan' => 'required|numeric|min:0|max:100',
            'nilai_sikap'     => 'required|numeric|min:0|max:100',
        ]);

        $pembimbing = Pembimbing::where('user_id', auth()->id())->firstOrFail();

        // 🔹 Hitung otomatis
        $nilaiTugas   = $this->hitungNilaiTugas($siswa_id);
        $nilaiLaporan = $this->hitungNilaiLaporan($siswa_id);

        $nilaiAkhir =
            ($nilaiTugas * 0.5) +
            ($nilaiLaporan * 0.3) +
            ($request->nilai_keaktifan * 0.1) +
            ($request->nilai_sikap * 0.1);

        PenilaianAkhir::updateOrCreate(
            [
                'siswa_id' => $siswa_id
            ],
            [
                'pembimbing_id'   => $pembimbing->id,
                'nilai_tugas'     => $nilaiTugas,
                'nilai_laporan'   => $nilaiLaporan,
                'nilai_keaktifan' => $request->nilai_keaktifan,
                'nilai_sikap'     => $request->nilai_sikap,
                'nilai_akhir'     => round($nilaiAkhir, 2),
                'periode_mulai'   => $request->periode_mulai,
                'periode_selesai' => $request->periode_selesai,
            ]
        );

        return redirect()
            ->route('pembimbing.penilaian_akhir.index')
            ->with('success', 'Nilai akhir berhasil disimpan');
    }

    /**
     * Hitung rata-rata semua tugas
     */
    private function hitungNilaiTugas($siswa_id)
    {
        return \DB::table('tugas_submit')
            ->where('siswa_id', $siswa_id)
            ->whereNotNull('skor')
            ->avg('skor') ?? 0;
    }

    /**
     * Hitung nilai laporan (contoh dari daily_report)
     */
    private function hitungNilaiLaporan($siswa_id)
    {
        return \DB::table('daily_report')
            ->where('siswa_id', $siswa_id)
            ->whereNotNull('nilai')
            ->avg('nilai') ?? 0;
    }
}
