@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 text-center">Pengaturan Akun Siswa</h3>
@if($statusProfile)
    <div class="alert alert-success d-flex align-items-center">
        <i class="ti ti-circle-check me-2"></i>
        <strong>Profile Lengkap</strong>
    </div>
@else
    <div class="alert alert-warning d-flex align-items-center">
        <i class="ti ti-alert-triangle me-2"></i>
        <strong>Profile belum lengkap.</strong> Lengkapi semua data & upload foto.
    </div>
@endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Form Profile Siswa</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Nama -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $profile->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- NISN -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" 
                                       value="{{ old('nisn', $profile->nisn) }}" required>
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <!-- Kelas -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" 
                                       value="{{ old('kelas', $profile->kelas) }}" required>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jurusan -->
                            <div class="col-12 col-md-6">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" 
                                       value="{{ old('jurusan', $profile->jurusan) }}" required>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="mt-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                            @if($profile->foto)
                                <div class="mt-2 d-flex justify-content-center">
                                    <img src="{{ asset('uploads/foto_siswa/'.$profile->foto) }}" alt="Foto Siswa" 
                                         class="rounded" style="max-width:150px; max-height:150px;">
                                </div>
                            @endif
                            @error('foto')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Profile</button>
                        </div>

                    </form>
                </div> <!-- card-body -->
            </div> <!-- card -->
        </div> <!-- col -->
    </div> <!-- row -->
</div> <!-- container -->
@endsection
