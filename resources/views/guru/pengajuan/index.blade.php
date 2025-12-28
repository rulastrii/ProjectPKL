@extends('layouts.app')

@section('content')
<h1>Daftar Pengajuan PKL/Magang</h1>

<a href="{{ route('guru.pengajuan.create') }}" class="btn btn-primary mb-3">Buat Pengajuan Baru</a>

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
                <a href="{{ route('guru.pengajuan.edit', $p->id) }}" class="btn btn-primary btn-sm">Edit / Tambah Siswa</a>
                @if($p->status == 'draft')
                    <form action="{{ route('guru.pengajuan.submit', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                    </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
