@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
            <div class="col-12 col-lg-6">
  <div class="row row-cards">

    <!-- Card 1 -->
    <div class="col-12 col-sm-6">
      <div class="card card-sm h-100">
        <div class="card-body d-flex align-items-center">
          <span class="avatar bg-primary text-white me-3">
            <i class="ti ti-users fs-1"></i>
          </span>
          <div>
            <div class="fw-bold fs-3">132</div>
            <div class="text-secondary">Jumlah Siswa Bimbingan</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-12 col-sm-6">
      <div class="card card-sm h-100">
        <div class="card-body d-flex align-items-center">
          <span class="avatar bg-danger text-white me-3">
            <i class="ti ti-file-description fs-1"></i>
          </span>
          <div>
            <div class="fw-bold fs-3">78</div>
            <div class="text-secondary">Laporan Belum Diverifikasi</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-12 col-sm-6">
      <div class="card card-sm h-100">
        <div class="card-body d-flex align-items-center">
          <span class="avatar bg-yellow text-white me-3">
            <i class="ti ti-clock fs-1"></i>
          </span>
          <div>
            <div class="fw-bold fs-3">23</div>
            <div class="text-secondary">Presensi Pending</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="col-12 col-sm-6">
      <div class="card card-sm h-100">
        <div class="card-body d-flex align-items-center">
          <span class="avatar bg-green text-white me-3">
            <i class="ti ti-book-2 fs-1"></i>
          </span>
          <div>
            <div class="fw-bold fs-3">15</div>
            <div class="text-secondary">Submit Tugas Baru</div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

              <div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Aktivitas Terbaru</h3>
    </div>

    <!-- SCROLL AREA -->
    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
      <table class="table card-table table-vcenter">
        <tbody>
          <tr>
            <td class="w-1 text-secondary">1.</td>
            <td><strong>Siswa A</strong> mengisi laporan harian</td>
            <td class="text-nowrap text-secondary">30 Jan</td>
          </tr>
          <tr>
            <td class="w-1 text-secondary">2.</td>
            <td><strong>Siswa B</strong> submit tugas Modul 2</td>
            <td class="text-nowrap text-secondary">Hari ini</td>
          </tr>
          <tr>
            <td class="w-1 text-secondary">3.</td>
            <td><strong>Siswa C</strong> presensi masuk pukul 08.00</td>
            <td class="text-nowrap text-secondary">Hari ini</td>
          </tr>
          <tr>
            <td class="w-1 text-secondary">4.</td>
            <td><strong>Siswa D</strong> mengisi laporan harian</td>
            <td class="text-nowrap text-secondary">29 Jan</td>
          </tr>
          <tr>
            <td class="w-1 text-secondary">5.</td>
            <td><strong>Siswa E</strong> submit tugas Modul 1</td>
            <td class="text-nowrap text-secondary">28 Jan</td>
          </tr>

          <!-- DATA KE-6 dst → otomatis muncul scroll -->
          <tr>
            <td class="w-1 text-secondary">6.</td>
            <td><strong>Siswa F</strong> presensi keluar pukul 16.00</td>
            <td class="text-nowrap text-secondary">28 Jan</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="col-md-6">
  <div class="card">

    <!-- HEADER -->
    <div class="card-header">
      <h3 class="card-title">Daftar Siswa Bimbingan</h3>
    </div>

    <!-- TABLE (SCROLL JIKA > 6 DATA) -->
    <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
      <table class="table card-table table-vcenter table-hover">
        <thead class="sticky-top bg-white">
          <tr>
            <th>Nama Siswa</th>
            <th>Sekolah</th>
            <th>Periode PKL</th>
            <th class="text-center">Progress</th>
            <th class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>

          <tr style="cursor:pointer">
            <td>Siswa A</td>
            <td>SMK 1 Jakarta</td>
            <td>Jan – Mar 2024</td>
            <td class="text-center text-warning fw-semibold">70%</td>
            <td class="text-center">
              <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
            </td>
          </tr>

          <tr style="cursor:pointer">
            <td>Siswa B</td>
            <td>SMA 1 Bandung</td>
            <td>Jan – Mar 2024</td>
            <td class="text-center text-primary fw-semibold">75%</td>
            <td class="text-center">
              <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
            </td>
          </tr>

          <tr style="cursor:pointer">
            <td>Siswa C</td>
            <td>SMA Al Azhar</td>
            <td>Jan – Mar 2024</td>
            <td class="text-center text-success fw-semibold">85%</td>
            <td class="text-center">
              <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
            </td>
          </tr>

          <tr style="cursor:pointer">
            <td>Siswa D</td>
            <td>SMK 2 Surabaya</td>
            <td>Feb – Apr 2024</td>
            <td class="text-center text-danger fw-semibold">55%</td>
            <td class="text-center">
              <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
            </td>
          </tr>

          <tr style="cursor:pointer">
            <td>Siswa E</td>
            <td>SMA 3 Yogyakarta</td>
            <td>Feb – Apr 2024</td>
            <td class="text-center text-success fw-semibold">90%</td>
            <td class="text-center">
              <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
            </td>
          </tr>

          <tr style="cursor:pointer">
            <td>Siswa F</td>
            <td>SMK 1 Medan</td>
            <td>Mar – Mei 2024</td>
            <td class="text-center text-warning fw-semibold">68%</td>
            <td class="text-center">
              <a href="#" class="btn btn-outline-primary btn-sm">Detail</a>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

  </div>
</div>

              <div class="col-md-6">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Aksi Cepat</h3>
    </div>

    <div class="card-body">

      <!-- 1. Buat Tugas Baru -->
      <div class="mb-3">
        <div class="card text-white bg-success">
          <div class="card-body d-flex align-items-center">
            <i class="ti ti-plus me-3" style="font-size: 2rem;"></i>
            <h5 class="mb-0">Buat Tugas Baru</h5>
          </div>
        </div>
      </div>

      <!-- 2. Verifikasi Presensi -->
      <div class="mb-3">
        <div class="card text-white bg-yellow">
          <div class="card-body d-flex align-items-center">
            <i class="ti ti-clock me-3" style="font-size: 2rem;"></i>
            <h5 class="mb-0">Verifikasi Presensi</h5>
          </div>
        </div>
      </div>

      <!-- 3. Verifikasi Laporan Harian -->
      <div class="mb-3">
        <div class="card text-white" style="background-color:#6f42c1;">
          <div class="card-body d-flex align-items-center">
            <i class="ti ti-file-description me-3" style="font-size: 2rem;"></i>
            <h5 class="mb-0">Verifikasi Laporan Harian</h5>
          </div>
        </div>
      </div>

      <!-- 4. Lihat Rekap Peserta -->
      <div>
        <div class="card text-white bg-primary">
          <div class="card-body d-flex align-items-center">
            <i class="ti ti-chart-bar me-3" style="font-size: 2rem;"></i>
            <h5 class="mb-0">Lihat Rekap Peserta</h5>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>


            </div>
          </div>
        </div>
@endsection
