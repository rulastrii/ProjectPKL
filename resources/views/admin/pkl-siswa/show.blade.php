@extends('layouts.app')

@section('title', 'Detail Siswa PKL')

@section('content')
<div class="container-xl mt-4">
    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">
                <i class="ti ti-user me-2"></i> Detail Siswa PKL
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered mb-4">
                <tr>
                    <th width="30%">Nama</th>
                    <td>{{ $siswa->nama_siswa }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $siswa->email_siswa }}</td>
                </tr>
                <tr>
                    <th>Sekolah</th>
                    <td>{{ $siswa->pengajuan->sekolah->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Periode</th>
                    <td>
                        {{ optional($siswa->pengajuan->periode_mulai)->format('d M Y') ?? '-' }}
                        s/d
                        {{ optional($siswa->pengajuan->periode_selesai)->format('d M Y') ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge 
                            @if($siswa->status == 'diterima') text-success
                            @elseif($siswa->status == 'ditolak') text-danger
                            @elseif($siswa->status == 'diproses') text-warning
                            @else text-secondary @endif">
                            {{ strtoupper($siswa->status ?? '-') }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Catatan Admin</th>
                    <td>{{ $siswa->catatan_admin ?? '-' }}</td>
                </tr>
            </table>

            <h5>Guru Pembimbing</h5>
              @if($guru)
                  <ul>
                      <li>{{ $guru->name ?? '-' }} ({{ $guru->email ?? '-' }})</li>
                  </ul>
              @else
                  <p class="text-muted">Belum ada pembimbing guru</p>
              @endif

        </div>

        <div class="card-footer text-end">
            <a href="{{ route('admin.pkl-siswa.index') }}" class="btn btn-primary">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>
@endsection
