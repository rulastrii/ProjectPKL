@extends('layouts.landing')

@section('title', 'Daftar Magang Mahasiswa')

@section('content')
<div class="container-fluid py-5 bg-light">
  <div class="container">

    {{-- Header --}}
    <div class="text-center mb-5">
      <span class="badge bg-primary mb-2">Pendaftaran Magang</span>
      <h1 class="fw-bold">Form Pengajuan Magang Mahasiswa</h1>
      <p class="text-muted">
        Silakan lengkapi data dengan benar. Tim kami akan menghubungi Anda melalui email.
      </p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">

        <div class="card shadow border-0 rounded-4">
          <div class="card-body p-4 p-md-5">

            {{-- Success Alert --}}
            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-1"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
              <div class="alert alert-danger">
                <strong>Periksa kembali isian Anda:</strong>
                <ul class="mb-0 mt-2">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('magang.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
              @csrf

              {{-- DATA MAHASISWA --}}
              <h5 class="mb-3 border-bottom pb-2"> Data Mahasiswa</h5>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" name="nama_mahasiswa"
                         class="form-control"
                         value="{{ old('nama_mahasiswa') }}"
                         placeholder="Nama sesuai KTP"
                         required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Email Aktif</label>
                  <input type="email" name="email_mahasiswa"
                         class="form-control"
                         value="{{ old('email_mahasiswa') }}"
                         placeholder="example@email.com"
                         required>
                  <small class="text-muted">
                    Email ini akan digunakan untuk notifikasi
                  </small>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Universitas</label>
                  <input type="text" name="universitas"
                         class="form-control"
                         value="{{ old('universitas') }}"
                         placeholder="Nama Universitas"
                         required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Jurusan</label>
                  <input type="text" name="jurusan"
                         class="form-control"
                         value="{{ old('jurusan') }}"
                         placeholder="Nama Jurusan">
                </div>
              </div>

              {{-- PERIODE MAGANG --}}
              <h5 class="mb-3 border-bottom pb-2"> Periode Magang</h5>

              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label class="form-label">Tanggal Mulai</label>
                  <input type="date"
                         name="periode_mulai"
                         id="periode_mulai"
                         class="form-control"
                         value="{{ old('periode_mulai') }}"
                         required>
                </div>

                <div class="col-md-6">
                  <label class="form-label">Tanggal Selesai</label>
                  <input type="date"
                         name="periode_selesai"
                         id="periode_selesai"
                         class="form-control"
                         value="{{ old('periode_selesai') }}"
                         required>
                </div>
              </div>

              {{-- DOKUMEN --}}
              <h5 class="mb-3 border-bottom pb-2"> Dokumen Pendukung</h5>

              <div class="mb-4">
                <label class="form-label">
                  Surat Pengantar Kampus (PDF)
                </label>
                <input type="file"
                       name="file_surat_path"
                       class="form-control"
                       accept="application/pdf"
                       required>
                <small class="text-muted">
                  Maksimal 2MB, format PDF
                </small>
              </div>

              {{-- SUBMIT --}}
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                  <i class="bi bi-shield-check"></i>
                  Data Anda aman dan hanya digunakan untuk keperluan magang
                </small>

                <button type="submit"
                        class="btn btn-primary px-4 py-2">
                  <i class="bi bi-send me-1"></i>
                  Kirim Pengajuan
                </button>
              </div>

            </form>

          </div>
        </div>

      </div>
    </div>

  </div>
</div>

{{-- Script --}}
<script>
document.getElementById('periode_mulai').addEventListener('change', function () {
    const mulai = this.value;
    const selesai = document.getElementById('periode_selesai');
    selesai.min = mulai;
});
</script>
@endsection
