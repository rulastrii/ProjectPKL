@extends('layouts.app')

@section('title','Detail Guru')

@section('content')
<div class="container-xl mt-4">
    <div class="card shadow-sm">

        {{-- Header --}}
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">
                <i class="ti ti-user me-2"></i> Detail Guru
            </h3>
        </div>

        {{-- Body --}}
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Lengkap</th>
                    <td>{{ $guru->user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $guru->user->email }}</td>
                </tr>
                <tr>
                    <th>NIP</th>
                    <td>{{ $guru->nip ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sekolah Mengajar</th>
                    <td>{{ $guru->sekolah }}</td>
                </tr>
                <tr>
                    <th>Status Verifikasi</th>
                    <td>
                        @if($guru->status_verifikasi === 'approved')
                            <span class="badge text-success">Disetujui</span>
                        @elseif($guru->status_verifikasi === 'pending')
                            <span class="badge text-warning">Menunggu</span>
                        @else
                            <span class="badge text-danger">Ditolak</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Dokumen Verifikasi</th>
                    <td>
                        @if($guru->dokumen_verifikasi)
                            <a href="{{ asset($guru->dokumen_verifikasi) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary">
                                Lihat Dokumen
                            </a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        {{-- Footer --}}
        <div class="card-footer text-end">
            <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>
@endsection
