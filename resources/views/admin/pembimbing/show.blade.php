@extends('layouts.app')

@section('title', 'Detail Pembimbing')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="ti ti-user-check me-2"></i>Detail Pembimbing</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">ID</th>
                            <td>{{ $pembimbing->id }}</td>
                        </tr>
                        <tr>
                            <th>Pegawai</th>
                            <td>{{ $pembimbing->pegawai->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pengajuan</th>
                            <td>
                                {{ $pembimbing->pengajuan->no_surat ?? '-' }}
                                @if($pembimbing->pengajuan && $pembimbing->pengajuan->sekolah)
                                    <br><small class="text-body">{{ $pembimbing->pengajuan->sekolah->nama }}</small>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Tahun</th>
                            <td>{{ $pembimbing->tahun ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($pembimbing->is_active)
                                    <span class="badge bg-success-soft text-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $pembimbing->created_date ? $pembimbing->created_date->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diperbarui</th>
                            <td>{{ $pembimbing->updated_date ? $pembimbing->updated_date->format('d M Y H:i') : '-' }}</td>
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
