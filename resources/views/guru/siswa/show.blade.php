@extends('layouts.app')

@section('title', 'Detail Siswa PKL')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="ti ti-user me-2"></i> Detail Siswa PKL
            </h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" style="width:30%">Nama</th>
                            <td>{{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td>{{ $siswa->email_siswa ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Sekolah</th>
                            <td>{{ $siswa->pengajuan->sekolah->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                @php
                                    $statusClass = match($siswa->status) {
                                        'draft'     => 'text-secondary',
                                        'diproses'  => 'text-warning',
                                        'diterima'  => 'text-success',
                                        'ditolak'   => 'text-danger',
                                        'selesai'   => 'text-primary',
                                        default     => 'text-muted',
                                    };
                                @endphp

                                <span class="badge badge-outline {{ $statusClass }}">
                                    {{ ucfirst($siswa->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Dibuat</th>
                            <td>{{ $siswa->created_at?->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Diperbarui</th>
                            <td>{{ $siswa->updated_at?->format('d M Y H:i') ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('guru.siswa.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
