@extends('layouts.app')

@section('content')
<h1>Edit Pengajuan PKL</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('siswa.pengajuan.update', $pengajuan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Sekolah -->
    <div class="form-group">
        <label>Sekolah</label>
        <select name="sekolah_id" class="form-control" required>
            <option value="">-- Pilih Sekolah --</option>
            @foreach($sekolah as $s)
                <option value="{{ $s->id }}" 
                    {{ $pengajuan->sekolah_id == $s->id ? 'selected' : '' }}>
                    {{ $s->nama }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Jumlah Siswa -->
    <div class="form-group">
        <label>Jumlah Siswa</label>
        <input type="number" name="jumlah_siswa" class="form-control" 
            value="{{ old('jumlah_siswa', $pengajuan->jumlah_siswa) }}" required>
    </div>

    <!-- Periode Mulai -->
    <div class="form-group">
        <label>Periode Mulai</label>
        <input type="date" name="periode_mulai" class="form-control" 
            value="{{ old('periode_mulai', $pengajuan->periode_mulai) }}" required>
    </div>

    <!-- Periode Selesai -->
    <div class="form-group">
        <label>Periode Selesai</label>
        <input type="date" name="periode_selesai" class="form-control" 
            value="{{ old('periode_selesai', $pengajuan->periode_selesai) }}" required>
    </div>

    <!-- File Surat -->
    <div class="form-group">
        <label>File Surat (PDF)</label>
        <input type="file" name="file_surat" class="form-control">
        @if($pengajuan->file_surat_path)
            <p>Lampiran saat ini: 
                <a href="{{ asset('storage/'.$pengajuan->file_surat_path) }}" target="_blank">
                    Lihat File
                </a>
            </p>
        @endif
    </div>

    <!-- Catatan (opsional) -->
    <div class="form-group">
        <label>Catatan</label>
        <textarea name="catatan" class="form-control" rows="3">{{ old('catatan', $pengajuan->catatan) }}</textarea>
    </div>

    <button type="submit" class="btn btn-success mt-2">💾 Update Pengajuan</button>
    <a href="{{ route('siswa.pengajuan.index') }}" class="btn btn-secondary mt-2">⬅ Kembali</a>
</form>
@endsection
