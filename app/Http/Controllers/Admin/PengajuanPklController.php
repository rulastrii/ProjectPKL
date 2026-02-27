<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPklmagang;
use App\Models\PengajuanPklSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiswaApprovedMail;
use App\Mail\SiswaRejectedMail;
use Barryvdh\DomPDF\Facade\Pdf;


class PengajuanPklController extends Controller
{
    /**
     * List pengajuan yang diproses
     */
    public function index(Request $request)
{
    $statusFilter = $request->status ?? 'all';

    $query = PengajuanPklmagang::with('siswa')
        ->where('is_active', 1);

    // Filter berdasarkan status siswa
    if ($statusFilter !== 'all') {
        $query->whereHas('siswa', function($q) use ($statusFilter) {
            $q->where('status', $statusFilter);
        });
    }

    // Search
    if ($request->filled('search')){
        $query->where('no_surat','like',"%{$request->search}%")
              ->orWhereHas('sekolah', function($q) use ($request){
                  $q->where('nama','like',"%{$request->search}%");
              });
    }

    $perPage = $request->per_page ?? 10;
    $pengajuans = $query->orderBy('created_date','desc')->paginate($perPage)->withQueryString();

    return view('admin.pengajuan.index', compact('pengajuans', 'statusFilter'));
}




    /**
     * Form approve/reject siswa per pengajuan
     */
    public function edit($id)
    {
        $pengajuan = PengajuanPklmagang::with('siswa')->findOrFail($id);
        return view('admin.pengajuan.edit', compact('pengajuan'));
    }

    /**
     * Approve/reject siswa
     */
    public function update(Request $request, $pengajuanId)
{
    $request->validate([
        'siswa_status' => 'required|array', 
        'siswa_status.*' => 'in:diterima,ditolak',
        'catatan_admin' => 'sometimes|array',
    ]);

    $pengajuan = PengajuanPklmagang::with('siswa')->findOrFail($pengajuanId);

    DB::transaction(function() use ($pengajuan, $request) {

        foreach($request->siswa_status as $siswaId => $status){
            $pengajuanSiswa = PengajuanPklSiswa::findOrFail($siswaId);
            $pengajuanSiswa->status = $status;
            $pengajuanSiswa->catatan_admin = $request->catatan_admin[$siswaId] ?? null;
            $pengajuanSiswa->save();

            // Hanya jika diterima/ditolak
            if($status == 'diterima' || $status == 'ditolak'){

                // 1. Nomor surat balasan otomatis
                $no_surat = "B/400.14.5.4/".str_pad($pengajuan->id, 3, '0', STR_PAD_LEFT)."/SEKRE/".date('Y');

                // 2. Nama Kepala Dinas
                $ttd = "MA'RUF NURYASA, AP., M.M.";

                // 3. Generate PDF surat balasan
                $pdf = Pdf::loadView('admin.pengajuan.surat-balasan', [
                    'pengajuan' => $pengajuan,
                    'siswa'     => $pengajuanSiswa,
                    'no_surat'  => $no_surat,
                    'ttd'       => $ttd,
                ]);


                // 5. Kirim email/notification
                if($status == 'diterima'){
                    Mail::to($pengajuanSiswa->email_siswa)
    ->send(new \App\Mail\SiswaApprovedMail(
        $pengajuanSiswa, // data siswa
        $pdf,             // PDF DomPDF
        $no_surat,        // nomor surat
        $ttd               // nama kepala dinas
    ));


                } else {
                    Mail::to($pengajuanSiswa->email_siswa)
                        ->send(new \App\Mail\SiswaRejectedMail($pengajuanSiswa, $pdf));
                }
            }
        }

    });

    return redirect()->route('admin.pengajuan.index')
        ->with('success', 'Status siswa dan surat balasan berhasil diperbarui.');
}

    public function show($id)
{
    $pengajuan = PengajuanPklmagang::with('siswa')->findOrFail($id);
    return view('admin.pengajuan.show', compact('pengajuan'));
}

}
