@extends('layouts.app')

@section('content')
<h1>Form Pengajuan PKL</h1>
<form action="{{ route('siswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Sekolah</label>
        <select name="sekolah_id" class="form-control" required>
            <option value="">-- Pilih Sekolah --</option>
            @foreach($sekolah as $s)
                <option value="{{ $s->id }}">{{ $s->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label>Jumlah Siswa</label>
        <input type="number" name="jumlah_siswa" class="form-control" required>
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
        <label>File Surat (PDF)</label>
        <input type="file" name="file_surat" class="form-control">
    </div>
    <button type="submit" class="btn btn-success mt-2">+ Ajukan PKL</button>
</form>
@endsection
