<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PengajuanPklSiswa;

class SiswaRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanSiswa;

    public function __construct(PengajuanPklSiswa $pengajuanSiswa)
    {
        $this->pengajuanSiswa = $pengajuanSiswa;
    }

    public function build()
    {
        return $this->subject('Pengajuan PKL Anda Ditolak')
                    ->markdown('emails.siswa.rejected');
    }
}
