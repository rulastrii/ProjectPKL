@extends('layouts.app')

@section('title', 'Detail Sekolah')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="ti ti-building me-2"></i>Detail Sekolah</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 30%;">ID</th>
                            <td>{{ $sekolah->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama</th>
                            <td>{{ $sekolah->nama }}</td>
                        </tr>
                        <tr>
                            <th scope="row">NPSN</th>
                            <td>{{ $sekolah->npsn }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Alamat</th>
                            <td>{{ $sekolah->alamat }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Kontak</th>
                            <td>{{ $sekolah->kontak }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                @if($sekolah->is_active)
                                    <span class="badge bg-success-soft text-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger-soft text-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Dibuat</th>
                            <td>{{ $sekolah->created_date ? $sekolah->created_date->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Diperbarui</th>
                            <td>{{ $sekolah->updated_date ? $sekolah->updated_date->format('d M Y H:i') : '-' }}</td>
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
