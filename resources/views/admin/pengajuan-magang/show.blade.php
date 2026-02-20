@extends('layouts.app')

@section('title', 'Detail Pengajuan Magang Mahasiswa')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="ti ti-file-text me-2"></i>Detail Pengajuan Magang</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th scope="row" style="width: 30%;">ID</th>
                            <td>{{ $pengajuan->id }}</td>
                        </tr>
                        <tr>
                            <th scope="row">No Surat</th>
                            <td>{{ $pengajuan->no_surat ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Tanggal Surat</th>
                            <td>{{ $pengajuan->tgl_surat ? \Carbon\Carbon::parse($pengajuan->tgl_surat)->format('d M Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Nama Mahasiswa</th>
                            <td>{{ $pengajuan->nama_mahasiswa }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Email Mahasiswa</th>
                            <td>{{ $pengajuan->email_mahasiswa }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Universitas</th>
                            <td>{{ $pengajuan->universitas }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Jurusan</th>
                            <td>{{ $pengajuan->jurusan }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Periode</th>
                            <td>
                                {{ $pengajuan->periode_mulai->format('d M Y') }} - 
                                {{ $pengajuan->periode_selesai->format('d M Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">File Surat</th>
                            <td>
                                @if($pengajuan->file_surat_path)
                                <a href="{{ asset($pengajuan->file_surat_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        Lihat File
                                    </a>
                                @else
                                    <span class="text-muted">Tidak ada file</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Catatan</th>
                            <td>{{ $pengajuan->catatan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>
                                <span class="badge 
                                    @if($pengajuan->status=='draft') bg-secondary
                                    @elseif($pengajuan->status=='diproses') bg-warning text-dark
                                    @elseif($pengajuan->status=='diterima') bg-success
                                    @elseif($pengajuan->status=='ditolak') bg-danger
                                    @elseif($pengajuan->status=='selesai') bg-primary
                                    @endif text-white">
                                    {{ ucfirst($pengajuan->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Dibuat</th>
                            <td>{{ $pengajuan->created_date ? $pengajuan->created_date->format('d M Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th scope="row">Diperbarui</th>
                            <td>{{ $pengajuan->updated_date ? $pengajuan->updated_date->format('d M Y H:i') : '-' }}</td>
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
