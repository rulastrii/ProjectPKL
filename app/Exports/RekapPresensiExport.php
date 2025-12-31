<?php

namespace App\Exports;

use App\Models\Presensi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapPresensiExport implements FromCollection, WithHeadings
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $tanggalAwal  = $this->request->tanggal_awal ?? now()->startOfMonth()->toDateString();
        $tanggalAkhir = $this->request->tanggal_akhir ?? now()->endOfMonth()->toDateString();

        $query = Presensi::with([
            'siswa',
            'siswa.user',

            // MAGANG
            'siswa.pengajuan.penempatan.bidang',
            'siswa.pengajuan.pembimbing.pegawai',

            // PKL
            'siswa.pengajuanpkl.penempatan.bidang',
            'siswa.pengajuanpkl.pembimbing.pegawai',
        ])
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->where('is_active', 1);

        // filter nama
        if ($this->request->filled('nama')) {
            $query->whereHas('siswa', function ($q) {
                $q->where('nama', 'like', '%' . $this->request->nama . '%');
            });
        }

        // filter status
        if ($this->request->filled('status')) {
            $query->where('status', $this->request->status);
        }

        // filter jenis (PKL / Magang)
        if ($this->request->filled('jenis')) {
            $query->whereHas('siswa.user', function ($q) {
                if ($this->request->jenis === 'PKL') {
                    $q->where('role_id', 4);
                } elseif ($this->request->jenis === 'Magang') {
                    $q->where('role_id', '!=', 4);
                }
            });
        }

        $presensi = $query->get();

        return $presensi
            ->groupBy('siswa_id')
            ->map(function ($items) {

                $siswa = $items->first()->siswa;
                if (!$siswa) return null;

                // jenis
                $jenis = $siswa->user && $siswa->user->role_id == 4 ? 'PKL' : 'Magang';

                // pembimbing
                $pembimbing = '-';
                if (
                    optional($siswa->pengajuan)->pembimbing &&
                    $siswa->pengajuan->pembimbing->isNotEmpty()
                ) {
                    $pembimbing = optional(
                        $siswa->pengajuan->pembimbing->first()->pegawai
                    )->nama;
                }

                if (
                    optional($siswa->pengajuanpkl)->pembimbing &&
                    $siswa->pengajuanpkl->pembimbing->isNotEmpty()
                ) {
                    $pembimbing = optional(
                        $siswa->pengajuanpkl->pembimbing->first()->pegawai
                    )->nama;
                }

                // bidang
                $bidang = '-';
                if (optional($siswa->pengajuan)->penempatan) {
                    $bidang = optional(
                        $siswa->pengajuan->penempatan->bidang
                    )->nama;
                }

                if (optional($siswa->pengajuanpkl)->penempatan) {
                    $bidang = optional(
                        $siswa->pengajuanpkl->penempatan->bidang
                    )->nama;
                }

                return [
                    'Nama'       => $siswa->nama,
                    'Jenis'      => $jenis,
                    'Bidang'     => $bidang,
                    'Pembimbing' => $pembimbing,
                    'Hadir'      => $items->where('status', 'hadir')->count(),
                    'Izin'       => $items->where('status', 'izin')->count(),
                    'Sakit'      => $items->where('status', 'sakit')->count(),
                    'Absen'      => $items->where('status', 'absen')->count(),
                    'Total'      => $items->count(),
                ];
            })
            ->filter()
            ->values();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Jenis',
            'Bidang',
            'Pembimbing',
            'Hadir',
            'Izin',
            'Sakit',
            'Absen',
            'Total Hari',
        ];
    }
}
