<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\PengajuanPklSiswa;

class SiswaApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanSiswa;
    protected $pdfData;
    protected $no_surat;
    protected $ttd;

    /**
     * @param PengajuanPklSiswa $pengajuanSiswa
     * @param \Barryvdh\DomPDF\PDF|null $pdfData PDF yang sudah di-generate (opsional)
     * @param string|null $no_surat Nomor surat balasan (opsional)
     * @param string|null $ttd Nama Kepala Dinas (opsional)
     */
    public function __construct(PengajuanPklSiswa $pengajuanSiswa, $pdfData = null, $no_surat = null, $ttd = null)
    {
        $this->pengajuanSiswa = $pengajuanSiswa;
        $this->pdfData = $pdfData;
        $this->no_surat = $no_surat;
        $this->ttd = $ttd;
    }

    public function build()
    {
        $mail = $this->subject('Pengajuan PKL Anda Diterima')
                     ->view('emails.siswa.approved', [
                         'pengajuanSiswa' => $this->pengajuanSiswa,
                         'no_surat'       => $this->no_surat,
                         'ttd'            => $this->ttd,
                     ]);

        // Lampirkan PDF surat balasan jika tersedia
        if ($this->pdfData && $this->no_surat) {
            $mail->attachData(
                $this->pdfData->output(), // output PDF sebagai string
                "Surat-Balasan-{$this->no_surat}.pdf",
                ['mime' => 'application/pdf']
            );
        }

        return $mail;
    }
}
