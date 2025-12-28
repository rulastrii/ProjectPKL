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

class PengajuanPklController extends Controller
{
    /**
     * List pengajuan yang diproses
     */
    public function index()
    {
        $pengajuans = PengajuanPklmagang::with('siswa')
            ->where('status', 'diproses')
            ->get();

        return view('admin.pengajuan.index', compact('pengajuans'));
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
        ]);

        $pengajuan = PengajuanPklmagang::with('siswa')->findOrFail($pengajuanId);

        DB::transaction(function() use ($pengajuan, $request) {

            foreach($request->siswa_status as $siswaId => $status){
                $pengajuanSiswa = PengajuanPklSiswa::findOrFail($siswaId);
                $pengajuanSiswa->status = $status;
                $pengajuanSiswa->catatan_admin = $request->catatan_admin[$siswaId] ?? null;
                $pengajuanSiswa->save();

                // Kirim email ke siswa diterima atau ditolak
                if($status == 'diterima'){
                    Mail::to($pengajuanSiswa->email_siswa)->send(new SiswaApprovedMail($pengajuanSiswa));
                } else if($status == 'ditolak'){
                    Mail::to($pengajuanSiswa->email_siswa)->send(new SiswaRejectedMail($pengajuanSiswa));
                }
            }

            // cek apakah semua siswa sudah diterima/ditolak → ubah status pengajuan
            $total = $pengajuan->siswa()->count();
            $processed = $pengajuan->siswa()->whereIn('status', ['diterima','ditolak'])->count();

            if($total == $processed){
                $pengajuan->status = 'selesai';
                $pengajuan->save();
            }
        });

        return redirect()->route('admin.pengajuan.index')->with('success', 'Status siswa berhasil diperbarui.');
    }
}
