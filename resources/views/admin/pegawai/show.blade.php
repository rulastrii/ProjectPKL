@extends('layouts.app')

@section('title', 'Detail Pegawai')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="ti ti-user me-2"></i>Detail Pegawai</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">ID</th>
                            <td>{{ $pegawai->id }}</td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td>{{ $pegawai->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pegawai->nama }}</td>
                        </tr>
                        <tr>
                            <th>Jabatan</th>
                            <td>{{ $pegawai->jabatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Bidang</th>
                            <td>{{ $pegawai->bidang->nama ?? '-' }}</td>
                        </tr>
                        
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pegawai->is_active)
                                    <span class="badge bg-success-soft text-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $pegawai->created_date ? $pegawai->created_date->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui</th>
                            <td>{{ $pegawai->updated_date ? $pegawai->updated_date->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                        <th>User Input</th>
                        <td>
                            @if($pegawai->createdBy)
                                {{ $pegawai->createdBy->name }} - 
                                <span class="badge bg-secondary text-white">
                                    {{ $pegawai->createdBy->role->name ?? 'No Role' }}
                                </span>
                                <br>
                                <small class="text-body">{{ $pegawai->createdBy->email }}</small>
                            @else
                                -
                            @endif
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer text-end">
            <a href="{{ url()->previous() }}" class="btn btn-primary">
                <i class="ti ti-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
