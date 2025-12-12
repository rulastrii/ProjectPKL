@extends('layouts.app')

@section('title', 'Detail Pengajuan PKL/Magang')

@section('content')
<div class="container my-5">

    <div class="card shadow-sm border-0">

        {{-- HEADER --}}
        <div class="card-header bg-primary text-white py-3">
            <h3 class="card-title mb-0">
                <i class="ti ti-file-description me-2"></i>Detail Pengajuan PKL/Magang
            </h3>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            <div class="row">

                {{-- KOLOM KIRI (INFO PENGAJUAN) --}}
                <div class="col-md-6">
    <div style="width:100%; border-bottom:2px solid #0d6efd; margin-bottom:15px; padding-bottom:6px;">
        <h5 class="fw-bold m-0">Informasi Pengajuan</h5>
    </div>


                    {{-- Sekolah --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Sekolah</small>
                        <div class="fw-semibold fs-5">{{ $pengajuan->sekolah->nama }}</div>
                    </div>

                    {{-- Jumlah Siswa --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Jumlah Siswa</small>
                        <div class="fw-semibold fs-5">{{ $pengajuan->jumlah_siswa }}</div>
                    </div>

                    {{-- Periode --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Periode</small>
                        <div class="fw-semibold fs-5">
                            {{ $pengajuan->periode_mulai }} s/d {{ $pengajuan->periode_selesai }}
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Status Pengajuan</small>

                        @php
                            $statusColor = [
                                'draft' => 'secondary',
                                'diproses' => 'warning',
                                'diterima' => 'success',
                                'ditolak' => 'danger',
                                'selesai' => 'info'
                            ];
                        @endphp

                        <span class="badge bg-{{ $statusColor[$pengajuan->status] ?? 'secondary' }} text-white px-3 py-2 fs-6">
                            {{ strtoupper($pengajuan->status) }}
                        </span>
                    </div>

                    {{-- File Surat --}}
                    @if($pengajuan->file_surat_path)
                    <div class="mb-4">
                        <small class="text-muted d-block">File Surat Pengajuan</small>
                        <a href="{{ asset($pengajuan->file_surat_path) }}" 
                           target="_blank"
                           class="btn btn-outline-primary btn-sm mt-2">
                            <i class="ti ti-file"></i> Lihat File
                        </a>
                    </div>
                    @endif

                </div>

                {{-- KOLOM KANAN (INFORMASI BALASAN) --}}
                <div class="col-md-6">
<div style="width:100%; border-bottom:2px solid #0d6efd; margin-bottom:15px; padding-bottom:6px;">
        <h5 class="fw-bold m-0">Informasi Balasan</h5>
    </div>



                    @if($pengajuan->status !== 'draft')

                    {{-- Nomor Surat --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Nomor Surat Balasan</small>
                        <div class="fw-semibold fs-5">{{ $pengajuan->no_surat ?? '-' }}</div>
                    </div>

                    {{-- Tanggal Surat --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Tanggal Surat Balasan</small>
                        <div class="fw-semibold fs-5">{{ $pengajuan->tgl_surat ?? '-' }}</div>
                    </div>

                    {{-- Catatan --}}
                    <div class="mb-4">
                        <small class="text-muted d-block">Catatan</small>
                        <div class="fw-semibold fs-5" style="line-height: 1.5;">
                            {!! nl2br(e($pengajuan->catatan ?? '-')) !!}
                        </div>
                    </div>

                    @else
                    <p class="text-muted fst-italic">Belum ada balasan surat.</p>
                    @endif

                    {{-- Metadata --}}
                    <div style="width:100%; border-bottom:2px solid #0d6efd; margin-bottom:15px; padding-bottom:6px;">
        <h6 class="fw-bold m-0 fs-5">Metadata</h6>
    </div>


                    <div class="mb-2">
                        <small class="text-muted d-block">Dibuat</small>
                        <div class="fw-semibold">
                            {{ $pengajuan->created_date ? $pengajuan->created_date->format('d M Y H:i') : '-' }}
                        </div>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted d-block">Diperbarui</small>
                        <div class="fw-semibold">
                            {{ $pengajuan->updated_date ? $pengajuan->updated_date->format('d M Y H:i') : '-' }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- FOOTER --}}
        <div class="card-footer text-end">
            <a href="{{ route('siswa.pengajuan.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>

            @if($pengajuan->status === 'draft')
            <a href="{{ route('siswa.pengajuan.edit', $pengajuan->id) }}" class="btn btn-warning ms-2">
                <i class="ti ti-edit"></i> Edit Pengajuan
            </a>
            @endif
        </div>

    </div>

</div>
@endsection
