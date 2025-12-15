@extends('layouts.app')
@section('title','Tambah Presensi Siswa')

@section('content')
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <h3 class="card-title">Tambah Presensi</h3>
          </div>

          <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="tab-masuk" data-bs-toggle="tab" href="#masuk" role="tab">Absen Masuk</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="tab-pulang" data-bs-toggle="tab" href="#pulang" role="tab">Absen Pulang</a>
              </li>
            </ul>

            <div class="tab-content mt-3">
              {{-- Masuk --}}
              <div class="tab-pane fade show active" id="masuk" role="tabpanel">
                <form action="{{ route('siswa.presensi.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="tab" value="masuk">

                  <div class="mb-3">
                    <label class="form-label">Nama Siswa</label>
                    <input type="text" class="form-control" value="{{ $siswa->nama }} - {{ $siswa->kelas }} - {{ $siswa->jurusan }}" readonly>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                      <option value="hadir">Hadir</option>
                      <option value="absen">Absen</option>
                      <option value="sakit">Sakit</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Foto Masuk</label>
                    <input type="file" name="foto_masuk" class="form-control">
                  </div>

                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Masuk</button>
                  </div>
                </form>
              </div>

              {{-- Pulang --}}
              <div class="tab-pane fade" id="pulang" role="tabpanel">
                <form action="{{ route('siswa.presensi.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="tab" value="pulang">

                  <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_keluar" class="form-control" required>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Foto Pulang</label>
                    <input type="file" name="foto_pulang" class="form-control">
                  </div>

                  <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan Pulang</button>
                  </div>
                </form>
              </div>

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
