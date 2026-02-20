@component('mail::message')
# Mohon Maaf

Halo {{ $pengajuanSiswa->email_siswa }},

Pengajuan PKL Anda untuk periode 
{{ \Carbon\Carbon::parse($pengajuanSiswa->pengajuan->periode_mulai)->format('d-m-Y') }}
sampai 
{{ \Carbon\Carbon::parse($pengajuanSiswa->pengajuan->periode_selesai)->format('d-m-Y') }} 
telah **DITOLAK**.

Alasan: {{ $pengajuanSiswa->catatan_admin ?? 'Tidak ada catatan' }}

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent
