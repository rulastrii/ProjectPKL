@extends('layouts.app')

@section('title', 'Detail Pengajuan PKL')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Detail Pengajuan PKL/Magang</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>No. Surat</th>
                    <td>{{ $pengajuan->no_surat }}</td>
                </tr>
                <tr>
                    <th>Sekolah/Universitas</th>
                    <td>{{ $pengajuan->sekolah?->nama ?? $pengajuan->universitas }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>
                        {{ $pengajuan->periode_mulai ? \Carbon\Carbon::parse($pengajuan->periode_mulai)->format('d M Y') : '-' }}
                        -
                        {{ $pengajuan->periode_selesai ? \Carbon\Carbon::parse($pengajuan->periode_selesai)->format('d M Y') : '-' }}
                    </td>
                </tr>
            </table>

            <h5 class="mt-4">Daftar Siswa</h5>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Catatan Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan->siswa as $index => $siswa)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $siswa->nama_siswa }}</td>
                            <td>{{ $siswa->email_siswa }}</td>
                            <td>
                                @php
                                    $sStatus = strtolower($siswa->status);
                                    $sClass = match($sStatus) {
                                        'diterima' => 'text-success',
                                        'ditolak' => 'text-danger',
                                        'diproses' => 'text-warning',
                                        default => 'text-secondary'
                                    };
                                @endphp
                                <span class="{{ $sClass }} fw-semibold">{{ ucfirst($siswa->status) }}</span>
                            </td>
                            <td>{{ $siswa->catatan_admin ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-primary">Kembali</a>
        </div>
    </div>
</div>
@endsection
