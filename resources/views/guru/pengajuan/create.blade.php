@extends('layouts.app')

@section('content')
<h1>Buat Pengajuan PKL/Magang</h1>

<form action="{{ route('guru.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label>No Surat</label>
        <input type="text" name="no_surat" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Tanggal Surat</label>
        <input type="date" name="tgl_surat" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Sekolah</label>
        <select name="sekolah_id" class="form-control" required>
            @foreach($sekolah as $s)
                <option value="{{ $s->id }}">{{ $s->nama }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Periode Mulai</label>
        <input type="date" name="periode_mulai" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Periode Selesai</label>
        <input type="date" name="periode_selesai" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Email Guru</label>
        <input type="email" name="email_guru" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Upload Surat (opsional)</label>
        <input type="file" name="file_surat_path" class="form-control">
    </div>

    <div class="form-group">
        <label>Catatan (opsional)</label>
        <textarea name="catatan" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success mt-2">Simpan Draft</button>
</form>
@endsection
