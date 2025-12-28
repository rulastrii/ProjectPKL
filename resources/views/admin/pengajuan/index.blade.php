@extends('layouts.app')

@section('content')
<h1>Daftar Pengajuan PKL/Magang</h1>

<table class="table">
    <thead>
        <tr>
            <th>No Surat</th>
            <th>Sekolah</th>
            <th>Periode</th>
            <th>Jumlah Siswa</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengajuans as $p)
        <tr>
            <td>{{ $p->no_surat }}</td>
            <td>{{ $p->sekolah->nama ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($p->periode_mulai)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($p->periode_selesai)->format('d-m-Y') }}</td>
            <td>{{ $p->jumlah_siswa }}</td>
            <td>{{ ucfirst($p->status) }}</td>
            <td>
                <a href="{{ route('admin.pengajuan.edit', $p->id) }}" class="btn btn-primary btn-sm">Proses</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
