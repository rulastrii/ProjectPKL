@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4 text-center">Pengaturan Akun Guru</h3>

    {{-- Status profile --}}
    @if($statusProfile)
        <div class="alert alert-success d-flex align-items-center rounded-3">
            <i class="ti ti-check-circle me-2"></i>
            <div>Profil guru sudah lengkap.</div>
        </div>
    @else
        <div class="alert alert-warning d-flex align-items-center rounded-3">
            <i class="ti ti-alert-triangle me-2"></i>
            <div>Profil guru belum lengkap.</div>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Profil Guru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('guru.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control"
                                       value="{{ $user->email }}" readonly>
                            </div>

                            {{-- Nama --}}
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control"
                                       value="{{ $user->name }}">
                            </div>

                            {{-- NIP --}}
                            <div class="col-md-6">
                                <label class="form-label">NIP</label>
                                <input type="text" name="nip"
                                       class="form-control @error('nip') is-invalid @enderror"   
                                        placeholder="Isi jika memiliki NIP"
                                       value="{{ old('nip', $profile->nip) }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sekolah --}}
                            <div class="col-md-6">
                                <label class="form-label">Sekolah Mengajar</label>
                                <input type="text" name="sekolah"
                                       class="form-control @error('sekolah') is-invalid @enderror"
                                       placeholder="Nama sekolah tempat mengajar"
                                       value="{{ old('sekolah', $profile->sekolah) }}"
                                       required>
                                @error('sekolah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        {{-- Status Verifikasi --}}
                        <div class="mt-4">
                            <label class="form-label">Status Verifikasi</label>
                            <div class="alert alert-success">
                                Akun Anda telah diverifikasi oleh admin.
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="mt-4">
                            <h5>Ubah Password (Opsional)</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Kosongkan jika tidak ingin mengubah password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation"
                                           class="form-control" placeholder="Ulangi password baru">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Simpan Profil
                            </button>
                        </div>

                    </form>

                    {{-- ================= FORM UPLOAD DOKUMEN ================= --}}
@if(is_null($user->created_by))
    <hr class="my-4">

    <label class="form-label">Dokumen Verifikasi</label>

    @if($profile->dokumen_verifikasi)
        <div class="alert alert-success">
            Dokumen sudah diupload.
            <br>
            <a href="{{ asset($profile->dokumen_verifikasi) }}" target="_blank">
                Lihat Dokumen
            </a>
        </div>
    @else
        <form action="{{ route('guru.profile.uploadDokumen') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            <input type="file"
                   name="dokumen_verifikasi"
                   class="form-control mb-2"
                   required>
            <button class="btn btn-sm btn-primary">
                Upload Dokumen
            </button>
        </form>
    @endif
@endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
