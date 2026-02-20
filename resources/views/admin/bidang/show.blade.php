@extends('layouts.app')

@section('title', 'Detail Bidang')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="ti ti-building me-2"></i>Detail Bidang</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 30%;">ID</th>
                            <td>{{ $bidang->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $bidang->nama }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kode</th>
                            <td>{{ $bidang->kode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                @if($bidang->is_active)
                                    <span class="badge bg-success-soft text-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Dibuat</th>
                            <td>{{ $bidang->created_date ? $bidang->created_date->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Diperbarui</th>
                            <td>{{ $bidang->updated_date ? $bidang->updated_date->format('d M Y H:i') : '-' }}</td>
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
