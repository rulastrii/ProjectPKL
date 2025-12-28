@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Detail Pengajuan PKL</h4>

    <div class="card mb-3">
        <div class="card-body">

            {{-- STATUS --}}
            <div class="mb-3">
                <span class="badge 
                    @if($pengajuan->status == 'draft') bg-secondary
                    @elseif($pengajuan->status == 'proses') bg-info text-dark
                    @elseif($pengajuan->status == 'disetujui') bg-success
                    @elseif($pengajuan->status == 'ditolak') bg-danger
                    @endif
                ">
                    {{ strtoupper($pengajuan->status) }}
                </span>
            </div>

            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Siswa</th>
    <td>
        @foreach($pengajuan->siswaProfile as $siswa)
            {{ $siswa->nama }} <br>
        @endforeach
    </td>

                </tr>
                <tr>
                    <th>Email Siswa</th>
                    <td>{{ $pengajuan->siswaProfile->user->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Sekolah Tujuan</th>
                    <td>{{ $pengajuan->sekolah->nama_sekolah ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah Siswa</th>
                    <td>{{ $pengajuan->jumlah_siswa }}</td>
                </tr>
                <tr>
                    <th>Periode PKL</th>
                    <td>
                        {{ \Carbon\Carbon::parse($pengajuan->periode_mulai)->format('d M Y') }}
                        s/d
                        {{ \Carbon\Carbon::parse($pengajuan->periode_selesai)->format('d M Y') }}
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>
                        {{ \Carbon\Carbon::parse($pengajuan->created_date)->format('d M Y H:i') }}
                    </td>
                </tr>
                <tr>
                    <th>Surat Pengantar</th>
                    <td>
                        @if($pengajuan->file_surat_path)
                            <a href="{{ asset($pengajuan->file_surat_path) }}"
                               target="_blank"
                               class="btn btn-sm btn-outline-primary">
                                Lihat Surat
                            </a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                </tr>

                {{-- CATATAN ADMIN (JIKA ADA) --}}
                @if($pengajuan->catatan)
                <tr>
                    <th>Catatan</th>
                    <td class="text-danger">
                        {{ $pengajuan->catatan }}
                    </td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    {{-- ACTION --}}
    <div class="d-flex justify-content-between">
        <a href="{{ route('guru.pengajuan.index') }}" class="btn btn-secondary">
            Kembali
        </a>

        @if($pengajuan->status === 'draft')
            <a href="{{ route('guru.pengajuan.edit', $pengajuan->id) }}"
               class="btn btn-warning">
                Edit Pengajuan
            </a>
        @endif
    </div>
</div>
@endsection
