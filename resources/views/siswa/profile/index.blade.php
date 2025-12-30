@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 text-center">Pengaturan Akun Siswa PKL</h3>

    @if($statusProfile)
        <div class="alert alert-success d-flex align-items-center rounded-3">
            <i class="ti ti-check-circle me-2"></i>
            <div>Profile PKL sudah lengkap.</div>
        </div>
    @else
        <div class="alert alert-warning d-flex align-items-center rounded-3">
            <i class="ti ti-alert-triangle me-2"></i>
            <div>Profile PKL belum lengkap. Lengkapi data & upload foto.</div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Profile Siswa PKL</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $email }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                                       value="{{ old('nama', $profile->nama) }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">NISN</label>
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" 
                                       value="{{ old('nisn', $profile->nisn) }}" required>
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror" 
                                       value="{{ old('kelas', $profile->kelas) }}" required>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" 
                                       value="{{ old('jurusan', $profile->jurusan) }}" required>
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <h5>Ubah Password (Opsional)</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Password Lama</label>
                                    <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Foto Profil</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
                            @if($profile->foto)
                                <div class="mt-2 d-flex justify-content-center">
                                    <img src="{{ asset('uploads/foto_siswa/'.$profile->foto) }}" 
                                         alt="Foto Siswa PKL" class="rounded-circle border" style="width:120px; height:120px;">
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
                </div>
            </div>
        </div> <!-- col -->
    </div> <!-- row -->
</div> <!-- container -->
@endsection
