@extends('layouts.app')

@section('title','Detail Guru')

@section('content')
<div class="container-xl mt-4">
    <div class="card shadow-sm">

        <!-- Header -->
        <div class="card-header d-flex align-items-center bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="ti ti-user me-2"></i> Detail Guru
            </h3>
        </div>

        <!-- Body -->
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Lengkap</th>
                    <td>{{ $guru->nama_lengkap }}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $guru->nip }}</td>
                </tr>
                <tr>
                    <th>Email Resmi</th>
                    <td>{{ $guru->email_resmi }}</td>
                </tr>
                <tr>
                    <th>Unit Kerja</th>
                    <td>{{ $guru->unit_kerja ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>{{ $guru->jabatan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status Kepegawaian</th>
                    <td>{{ $guru->status_kepegawaian ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Footer -->
        <div class="card-footer text-end">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
