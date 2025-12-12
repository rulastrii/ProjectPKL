@extends('layouts.app')

@section('title', 'Detail Pengajuan PKL/Magang')

@section('content')
<div class="page-body">
 <div class="container-xl">

  <div class="card">
   <div class="card-header">
    <h3 class="card-title">Detail Pengajuan PKL/Magang</h3>
   </div>

   <div class="card-body">

    <div class="row">

      {{-- Kolom Informasi Pengajuan --}}
      <div class="col-md-6">
        <h4 class="fw-bold mb-3">Informasi Pengajuan</h4>

        <p><b>No Surat:</b> {{ $pengajuan->no_surat ?? '-' }}</p>
        <p><b>Tanggal Surat:</b> {{ $pengajuan->tgl_surat ?? '-' }}</p>
        <p><b>Sekolah:</b> {{ $pengajuan->sekolah->nama }}</p>
        <p><b>Jumlah Siswa:</b> {{ $pengajuan->jumlah_siswa }}</p>
        <p><b>Periode Mulai:</b> {{ $pengajuan->periode_mulai }}</p>
        <p><b>Periode Selesai:</b> {{ $pengajuan->periode_selesai }}</p>

        <p>
          <b>Status:</b>
          <span class="badge 
    @if($pengajuan->status == 'draft') bg-secondary text-white
    @elseif($pengajuan->status == 'pending') bg-warning text-dark
    @elseif($pengajuan->status == 'proses') bg-primary text-white
    @elseif($pengajuan->status == 'diterima') bg-success text-white
    @elseif($pengajuan->status == 'ditolak') bg-danger text-white
    @endif">
    {{ ucfirst($pengajuan->status) }}
</span>

        </p>
      </div>

      {{-- Kolom Lampiran & Catatan --}}
      <div class="col-md-6">
        <h4 class="fw-bold mb-3">Lampiran & Catatan</h4>

        <p>
          <b>File Surat:</b><br>
          @if($pengajuan->file_surat_path)
              <a href="{{ asset($pengajuan->file_surat_path) }}"
                 target="_blank"
                 class="btn btn-outline-primary btn-sm">
                 <i class="ti ti-file-text me-1"></i> Lihat File
              </a>
          @else
              <span class="text-muted">Tidak ada file</span>
          @endif
        </p>

        <p>
          <b>Catatan:</b><br>
          {{ $pengajuan->catatan ?? '-' }}
        </p>
      </div>

    </div>

   </div>

   <div class="card-footer text-end">
      <a href="{{ url()->previous() }}" class="btn btn-primary">
          <i class="ti ti-arrow-left me-1"></i> Kembali
      </a>
   </div>

  </div>

 </div>
</div>
@endsection
