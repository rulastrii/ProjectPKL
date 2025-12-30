@extends('layouts.app')
@section('title','Detail Pengajuan PKL')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">

        {{-- HEADER --}}
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="ti ti-file-description me-2"></i>
                Detail Pengajuan PKL
                <span class="opacity-75 ms-2">{{ $pengajuan->no_surat }}</span>
            </h3>
        </div>

        {{-- BODY --}}
        <div class="card-body">

            {{-- INFO UTAMA --}}
            <div class="table-responsive mb-4">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th width="30%">Sekolah Tujuan</th>
                            <td>{{ $pengajuan->sekolah->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Periode PKL</th>
                            <td>
                                {{ \Carbon\Carbon::parse($pengajuan->periode_mulai)->format('d M Y') }}
                                s/d
                                {{ \Carbon\Carbon::parse($pengajuan->periode_selesai)->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Jumlah Siswa</th>
                            <td>{{ $pengajuan->jumlah_siswa }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                            <td>{{ \Carbon\Carbon::parse($pengajuan->created_date)->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Surat Pengantar</th>
                            <td>
                                @if($pengajuan->file_surat_path)
                                    <a href="{{ asset('storage/'.$pengajuan->file_surat_path) }}"
                                       target="_blank"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="ti ti-file-text me-1"></i> Lihat Surat
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- DAFTAR SISWA --}}
            <h4 class="mb-3">
                <i class="ti ti-users me-1"></i> Daftar Siswa
            </h4>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Catatan Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengajuan->siswa as $siswa)
                        <tr>
                            <td>{{ $siswa->nama_siswa }}</td>
                            <td>{{ $siswa->email_siswa ?? '-' }}</td>
                            <td>
                                @php
                                    $siswaClass = match($siswa->status) {
                                        'diterima' => 'text-success',
                                        'ditolak'  => 'text-danger',
                                        'diproses' => 'text-warning',
                                        default    => 'text-secondary',
                                    };
                                @endphp

                                <span class="badge {{ $siswaClass }}">
                                    {{ strtoupper($siswa->status) }}
                                </span>
                            </td>
                            <td>
                                @if($siswa->catatan_admin)
                                    <span class="text-muted">
                                        {{ $siswa->catatan_admin }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- CATATAN --}}
            @if($pengajuan->catatan)
            <div class="alert alert-warning mt-4">
                <strong>Catatan:</strong><br>
                {{ $pengajuan->catatan }}
            </div>
            @endif

        </div>

        {{-- FOOTER --}}
        <div class="card-footer text-end">
            <a href="{{ route('guru.pengajuan.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>

            @if($pengajuan->status === 'draft')
            <a href="{{ route('guru.pengajuan.edit', $pengajuan->id) }}"
               class="btn btn-warning ms-2">
                <i class="ti ti-pencil me-1"></i> Edit Pengajuan
            </a>
            @endif
        </div>

    </div>
</div>
@endsection
