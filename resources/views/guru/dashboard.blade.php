@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">

      <!-- Total Siswa Bimbingan -->
      <div class="col-md-4">
        <div class="card card-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <span class="bg-primary text-white avatar me-3">
                <i class="ti ti-users fs-1"></i>
              </span>
              <div>
                <div class="h3 mb-0">{{ $totalSiswa }}</div>
                <div class="text-secondary">Total Siswa Bimbingan</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Siswa Diterima -->
      <div class="col-md-4">
        <div class="card card-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <span class="bg-success text-white avatar me-3">
                <i class="ti ti-user-check fs-1"></i>
              </span>
              <div>
                <div class="h3 mb-0">{{ $pengajuanDisetujui }}</div>
                <div class="text-secondary">Siswa Diterima</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Siswa Ditolak -->
      <div class="col-md-4">
        <div class="card card-sm h-100">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <span class="bg-danger text-white avatar me-3">
                <i class="ti ti-user-x fs-1"></i>
              </span>
              <div>
                <div class="h3 mb-0">{{ $pengajuanDitolak }}</div>
                <div class="text-secondary">Siswa Ditolak</div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
