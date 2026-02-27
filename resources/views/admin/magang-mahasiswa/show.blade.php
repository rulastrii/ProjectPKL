@extends('layouts.app')

@section('title', 'Detail Magang Mahasiswa')

@section('content')
<div class="container-xl mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="ti ti-user me-2"></i> Detail Mahasiswa Magang 
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="30%" class="align-middle">Nama</th>
                        <td class="align-middle">{{ $siswa->nama }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">NIM</th>
                        <td class="align-middle">{{ $siswa->nim }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Universitas</th>
                        <td class="align-middle">{{ $siswa->pengajuan->universitas ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Jurusan</th>
                        <td class="align-middle">{{ $siswa->jurusan }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Periode</th>
                        <td class="align-middle">
                            {{ optional($siswa->pengajuan->periode_mulai)->format('d M Y') ?? '-' }}
                            s/d
                            {{ optional($siswa->pengajuan->periode_selesai)->format('d M Y') ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle">Status</th>
                        <td class="align-middle">
                            @php
                                $status = $siswa->pengajuan->status ?? '-';
                                $statusClass = match(strtolower($status)) {
                                    'diterima' => 'text-success',
                                    'ditolak' => 'text-danger',
                                    'diproses' => 'text-warning',
                                    default => 'text-secondary'
                                };
                            @endphp
                            <span class="badge {{ $statusClass }}">{{ strtoupper($status) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th class="align-middle">Catatan</th>
                        <td class="align-middle">{{ $siswa->pengajuan->catatan ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.magang-mahasiswa.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>
@endsection
