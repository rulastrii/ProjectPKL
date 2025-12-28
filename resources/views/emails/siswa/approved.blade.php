@component('mail::message')
# Selamat!

Halo {{ $pengajuanSiswa->email_siswa }},

Pengajuan PKL Anda untuk periode 
{{ \Carbon\Carbon::parse($pengajuanSiswa->pengajuan->periode_mulai)->format('d-m-Y') }}
sampai 
{{ \Carbon\Carbon::parse($pengajuanSiswa->pengajuan->periode_selesai)->format('d-m-Y') }} 
telah **DITERIMA**.

Silakan menunggu informasi selanjutnya dari pihak sekolah/magang.

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
