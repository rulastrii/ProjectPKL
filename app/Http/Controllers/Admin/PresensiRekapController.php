<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presensi;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RekapPresensiExport;
use Maatwebsite\Excel\Facades\Excel;

class PresensiRekapController extends Controller
{
    /**
     * Halaman rekap presensi
     */
    public function index(Request $request)
    {
        // =====================
        // DEFAULT PERIODE
        // =====================
        $tanggalAwal  = $request->tanggal_awal ?? now()->startOfMonth()->toDateString();
        $tanggalAkhir = $request->tanggal_akhir ?? now()->endOfMonth()->toDateString();

        // =====================
        // QUERY PRESENSI
        // =====================
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


        // filter nama siswa
        if ($request->filled('nama')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        

// filter jenis (PKL / Magang)
if ($request->filled('jenis')) {
    $query->whereHas('siswa.user', function ($q) use ($request) {
        if ($request->jenis === 'PKL') {
            $q->where('role_id', 4);
        }

        if ($request->jenis === 'Magang') {
            $q->where('role_id', 5);
        }
    });
}

        $presensi = $query->get();

        // =====================
        // REKAP PER SISWA
        // =====================
        $rekapCollection = $presensi
            ->groupBy('siswa_id')
            ->map(function ($items) {

                $siswa = $items->first()->siswa;

                if (!$siswa) {
                    return null;
                }

                $pembimbing = '-';

                // MAGANG
                if (
                    optional($siswa->pengajuan)->pembimbing &&
                    $siswa->pengajuan->pembimbing->isNotEmpty()
                ) {
                    $pembimbing = optional(
                        $siswa->pengajuan->pembimbing->first()->pegawai
                    )->nama;
                }

                // PKL
                if (
                    optional($siswa->pengajuanpkl)->pembimbing &&
                    $siswa->pengajuanpkl->pembimbing->isNotEmpty()
                ) {
                    $pembimbing = optional(
                        $siswa->pengajuanpkl->pembimbing->first()->pegawai
                    )->nama;
                }

                $jenis = '-';

if ($siswa->user) {
    if ($siswa->user->role_id == 4) {
        $jenis = 'PKL';
    } elseif ($siswa->user->role_id == 5) {
        $jenis = 'Magang';
    }
}

$bidang = '-';

// MAGANG
if (optional($siswa->pengajuan)->penempatan) {
    $bidang = optional(
        $siswa->pengajuan->penempatan->bidang
    )->nama;
}

// PKL
if (optional($siswa->pengajuanpkl)->penempatan) {
    $bidang = optional(
        $siswa->pengajuanpkl->penempatan->bidang
    )->nama;
}





                return [
                    'siswa_id' => $siswa->id,
                    'nama'     => $siswa->nama,
                    
                    'jenis'    => $jenis,
                                    
                    'bidang'   => $bidang,
                    'pembimbing' => $pembimbing,

                    'total_hari' => $items->count(),
                    'hadir'  => $items->where('status', 'hadir')->count(),
                    'izin'   => $items->where('status', 'izin')->count(),
                    'sakit'  => $items->where('status', 'sakit')->count(),
                    'absen'  => $items->where('status', 'absen')->count(),
                ];
            })
            ->filter()
            ->values();

        // =====================
        // PAGINATION MANUAL
        // =====================
        $perPage = $request->per_page ?? 10;
        $page    = $request->page ?? 1;

        $rekap = new LengthAwarePaginator(
            $rekapCollection->forPage($page, $perPage),
            $rekapCollection->count(),
            $perPage,
            $page,
            [
                'path'  => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('admin.presensi.index', compact(
            'rekap',
            'tanggalAwal',
            'tanggalAkhir'
        ));
    }

    /**
     * Detail presensi per siswa
     */
    public function detail($siswa_id, Request $request)
{
    $query = Presensi::where('siswa_id', $siswa_id);

    if ($request->filled('tanggal_awal')) {
        $query->whereDate('tanggal', '>=', $request->tanggal_awal);
    }

    if ($request->filled('tanggal_akhir')) {
        $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
    }

    $presensi = $query
        ->orderBy('tanggal', 'asc')
        ->get();

    return view('admin.presensi.detail', compact('presensi'));
}

public function exportPdf(Request $request)
{
    $tanggalAwal  = $request->tanggal_awal ?? now()->startOfMonth()->toDateString();
    $tanggalAkhir = $request->tanggal_akhir ?? now()->endOfMonth()->toDateString();

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
    if ($request->filled('nama')) {
        $query->whereHas('siswa', function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->nama . '%');
        });
    }

    // filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $presensi = $query->get();

    // REKAP (copy dari index)
    $rekap = $presensi
        ->groupBy('siswa_id')
        ->map(function ($items) {

            $siswa = $items->first()->siswa;
            if (!$siswa) return null;

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

            $jenis = '-';

if ($siswa->user) {
    if ($siswa->user->role_id == 4) {
        $jenis = 'PKL';
    } elseif ($siswa->user->role_id == 5) {
        $jenis = 'Magang';
    }
}


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
                'nama' => $siswa->nama,
                'jenis' => $jenis,
                'bidang' => $bidang,
                'pembimbing' => $pembimbing,
                'hadir' => $items->where('status','hadir')->count(),
                'izin' => $items->where('status','izin')->count(),
                'sakit' => $items->where('status','sakit')->count(),
                'absen' => $items->where('status','absen')->count(),
                'total' => $items->count(),
            ];
        })
        ->filter()
        ->values();

    $pdf = Pdf::loadView('admin.presensi.pdf', [
        'rekap' => $rekap,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
    ])->setPaper('A4', 'potrait');

    return $pdf->download(
        'Laporan_Presensi_' . $tanggalAwal . '_' . $tanggalAkhir . '.pdf'
    );
}



public function exportExcel(Request $request)
{
    return Excel::download(
        new RekapPresensiExport($request),
        'Laporan_Presensi_' .
        ($request->tanggal_awal ?? now()->startOfMonth()->toDateString()) .
        '_' .
        ($request->tanggal_akhir ?? now()->endOfMonth()->toDateString()) .
        '.xlsx'
    );
}

}
