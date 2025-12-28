@extends('layouts.app')

@section('content')
<h1>Edit Pengajuan PKL: {{ $pengajuan->no_surat }}</h1>

<h3>Daftar Siswa</h3>
<table class="table">
    <thead>
        <tr>
            <th>Email Siswa</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pengajuan->siswa as $s)
        <tr>
            <td>{{ $s->nama_siswa }}</td>
<td>{{ $s->email_siswa }}</td>

        </tr>
        @endforeach
    </tbody>
</table>

<h3>Tambah Siswa</h3>
<form action="{{ route('guru.pengajuan.addSiswa', $pengajuan->id) }}" method="POST">
    @csrf
    <div class="form-group">
    <label>Nama Siswa</label>
    <input type="text" name="nama_siswa" class="form-control" required>
</div>
<div class="form-group">
    <label>Email Siswa</label>
    <input type="email" name="email_siswa" class="form-control" required>
</div>

    <button type="submit" class="btn btn-primary mt-2">Tambah Siswa</button>
</form>

@if($pengajuan->status == 'draft')
    <form action="{{ route('guru.pengajuan.submit', $pengajuan->id) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-success">Submit Pengajuan</button>
    </form>
@endif

@endsection
