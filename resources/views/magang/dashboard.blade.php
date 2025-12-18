@extends('layouts.app')

@section('title', 'Dashboard Magang')

@section('content')

        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
              <div class="col-12">
                <div class="row row-cards align-items-stretch">
                  <div class="col-4">
    <div class="card card-sm h-100">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-auto">
                    <span class="bg-primary text-white avatar">
                        <i class="ti ti-clock fs-1"></i>
                    </span>
                </div>
                <div class="col">
                    <div class="font-weight-medium">
                        {{ $sudahPresensi ? 'Sudah Presensi' : 'Belum Presensi' }}
                    </div>
                    <div class="text-secondary">Status Presensi Hari Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>


                  <div class="col-4">
                    <div class="card card-sm h-100">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar">
                              <i class="ti ti-list-check fs-1"></i>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">6</div>
                            <div class="text-secondary">Jumlah Laporan Harian Dibuat Hari Ini</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-4">
                    <div class="card card-sm h-100">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-danger text-white avatar">
                              <i class="ti ti-alert-triangle fs-1"></i>
                            </span>
                          </div>
                          <div class="col">
                            <div class="font-weight-medium">5</div>
                            <div class="text-secondary">Jumlah Tugas Pending</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
             <div class="col-md-6 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Progress Magang</h3>
                </div>
                <div class="card-body">

                  <!-- Presensi -->
<div class="mb-3">
    <div class="d-flex justify-content-between">
        <span>Presensi</span>
        <span>{{ $jumlahPresensi }}/{{ $totalHariMagang }} hari ({{ $prosentasePresensi }}%)</span>
    </div>
    <div class="progress" style="height:10px;">
        <div class="progress-bar bg-primary" style="width:{{ $prosentasePresensi }}%;"></div>
    </div>
</div>

                  <!-- Laporan Harian -->
                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                      <span>Laporan Harian</span>
                      <span>13/20 hari (65%)</span>
                    </div>
                    <div class="progress" style="height:10px;">
                      <div class="progress-bar bg-success" style="width:65%;"></div>
                    </div>
                  </div>

                  <!-- Tugas -->
                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                      <span>Tugas</span>
                      <span>2/5 selesai (40%)</span>
                    </div>
                    <div class="progress" style="height:10px;">
                      <div class="progress-bar bg-warning" style="width:40%;"></div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Tugas Terbaru</h3>
                </div>
                <div class="card-body">
                  <div class="row">
                    <!-- Card 1 -->
                    <div class="col-md-4 mb-3">
                      <div class="card h-100">
                        <div class="card-body">
                          <h5 class="card-title">Membuat Laporan Mingguan</h5>
                          <p class="card-text">Tenggat: 3 Feb 2025</p>
                          <span class="badge" style="background-color: #fff9c4; color: #000;">Belum Submit</span>
                        </div>
                      </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col-md-4 mb-3">
                      <div class="card h-100">
                        <div class="card-body">
                          <h5 class="card-title">Membuat Ringkasan Proyek</h5>
                          <p class="card-text">Tenggat: 10 Feb 2025</p>
                          <span class="badge" style="background-color: #fff9c4; color: #000;">Belum Submit</span>
                        </div>
                      </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-md-4 mb-3">
                      <div class="card h-100">
                        <div class="card-body">
                          <h5 class="card-title">Membuat Presentasi Akhir</h5>
                          <p class="card-text">Tenggat: 15 Feb 2025</p>
                          <span class="badge" style="background-color: #fff9c4; color: #000;">Belum Submit</span>
                        </div>
                      </div>
                    </div>
                  </div> <!-- end row -->
                </div> <!-- end card-body -->
              </div> <!-- end card -->
            </div>

              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Invoices</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                      <div class="text-secondary">
                        Show
                        <div class="mx-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                        </div>
                        entries
                      </div>
                      <div class="ms-auto text-secondary">
                        Search:
                        <div class="ms-2 d-inline-block">
                          <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                      <thead>
                        <tr>
                          <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                          <th class="w-1">No. <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                          </th>
                          <th>Invoice Subject</th>
                          <th>Client</th>
                          <th>VAT No.</th>
                          <th>Created</th>
                          <th>Status</th>
                          <th>Price</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001401</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Design Works</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-us me-2"></span>
                            Carlson Limited
                          </td>
                          <td>
                            87956621
                          </td>
                          <td>
                            15 Dec 2017
                          </td>
                          <td>
                            <span class="badge bg-success me-1"></span> Paid
                          </td>
                          <td>$887</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001402</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">UX Wireframes</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-gb me-2"></span>
                            Adobe
                          </td>
                          <td>
                            87956421
                          </td>
                          <td>
                            12 Apr 2017
                          </td>
                          <td>
                            <span class="badge bg-warning me-1"></span> Pending
                          </td>
                          <td>$1200</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001403</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">New Dashboard</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-de me-2"></span>
                            Bluewolf
                          </td>
                          <td>
                            87952621
                          </td>
                          <td>
                            23 Oct 2017
                          </td>
                          <td>
                            <span class="badge bg-warning me-1"></span> Pending
                          </td>
                          <td>$534</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001404</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Landing Page</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-br me-2"></span>
                            Salesforce
                          </td>
                          <td>
                            87953421
                          </td>
                          <td>
                            2 Sep 2017
                          </td>
                          <td>
                            <span class="badge bg-secondary me-1"></span> Due in 2 Weeks
                          </td>
                          <td>$1500</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001405</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Marketing Templates</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-pl me-2"></span>
                            Printic
                          </td>
                          <td>
                            87956621
                          </td>
                          <td>
                            29 Jan 2018
                          </td>
                          <td>
                            <span class="badge bg-danger me-1"></span> Paid Today
                          </td>
                          <td>$648</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001406</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Sales Presentation</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-br me-2"></span>
                            Tabdaq
                          </td>
                          <td>
                            87956621
                          </td>
                          <td>
                            4 Feb 2018
                          </td>
                          <td>
                            <span class="badge bg-secondary me-1"></span> Due in 3 Weeks
                          </td>
                          <td>$300</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001407</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Logo & Print</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-us me-2"></span>
                            Apple
                          </td>
                          <td>
                            87956621
                          </td>
                          <td>
                            22 Mar 2018
                          </td>
                          <td>
                            <span class="badge bg-success me-1"></span> Paid Today
                          </td>
                          <td>$2500</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        <tr>
                          <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                          <td><span class="text-secondary">001408</span></td>
                          <td><a href="invoice.html" class="text-reset" tabindex="-1">Icons</a></td>
                          <td>
                            <span class="flag flag-xs flag-country-pl me-2"></span>
                            Tookapic
                          </td>
                          <td>
                            87956621
                          </td>
                          <td>
                            13 May 2018
                          </td>
                          <td>
                            <span class="badge bg-success me-1"></span> Paid Today
                          </td>
                          <td>$940</td>
                          <td class="text-end">
                            <span class="dropdown">
                              <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                              <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">
                                  Action
                                </a>
                                <a class="dropdown-item" href="#">
                                  Another action
                                </a>
                              </div>
                            </span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="card-footer d-flex align-items-center">
                    <p class="m-0 text-secondary">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                    <ul class="pagination m-0 ms-auto">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                          <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                          prev
                        </a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item active"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">4</a></li>
                      <li class="page-item"><a class="page-link" href="#">5</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">
                          next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>

              <div class="col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Aksi Cepat</h3>
                  </div>
                  <div class="card-body">
                    <div class="row">

                      <!-- Card 1: Presensi -->
<div class="col-md-3 mb-3">
  <div class="card h-100 text-center bg-primary text-white" data-bs-toggle="modal" data-bs-target="#presensiModal" style="cursor:pointer;">
    <div class="card-body d-flex flex-column align-items-center justify-content-center">
      <i class="ti ti-clock" style="font-size: 2rem;"></i>
      <h5 class="card-title mt-2">Presensi Masuk / Keluar</h5>
    </div>
  </div>
</div>

                     <!-- Card 2: Buat Laporan -->
                      <div class="col-md-3 mb-3">
                        <div class="card h-100 text-center bg-success text-white">
                          <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <i class="ti ti-list-check" style="font-size: 2rem;"></i> <!-- Icon Input Buku -->
                            <h5 class="card-title mt-2">Buat Laporan Harian</h5>
                          </div>
                        </div>
                      </div>
                      <!-- Card 3: Lihat Semua Tugas -->
                        <div class="col-md-3 mb-3">
                          <div class="card h-100 text-center" style="background-color: #6f42c1; color: white;"> <!-- Ungu custom -->
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                              <i class="ti ti-book" style="font-size: 2rem;"></i> <!-- Icon Buku Terbuka -->
                              <h5 class="card-title mt-2">Lihat Semua Tugas</h5>
                            </div>
                          </div>
                        </div>

                        <!-- Card 4: Lihat Penilaian -->
                        <div class="col-md-3 mb-3">
                          <div class="card h-100 text-center bg-yellow text-white">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                              <i class="ti ti-star" style="font-size: 2rem;"></i> <!-- Icon Bintang -->
                              <h5 class="card-title mt-2">Lihat Penilaian Akhir</h5>
                            </div>
                          </div>
                        </div>

                    </div> <!-- end row -->
                  </div> <!-- end card-body -->
                </div> <!-- end card -->
              </div>

            </div>
          </div>
        </div>

        <!-- Modal Presensi -->
<div class="modal fade" id="presensiModal" tabindex="-1">
  <div class="modal-dialog modal-fullscreen-sm-down modal-dialog-centered modal-lg">
    <div class="modal-content border-0">

      {{-- HEADER --}}
      <div class="modal-header bg-primary text-white">
        <div>
          <h5 class="modal-title mb-0">Presensi Hari Ini</h5>
          <small>{{ now()->format('d F Y') }}</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      {{-- BODY --}}
      <div class="modal-body p-3 p-md-4">

        @php
          $jamMasuk = $todayPresensi?->jam_masuk;
          $jamPulang = $todayPresensi?->jam_keluar;
          $absenMasukSudah = !is_null($jamMasuk);
          $absenPulangSudah = !is_null($jamPulang);
        @endphp

        {{-- STATUS --}}
        <div class="alert {{ $absenMasukSudah ? 'alert-success' : 'alert-warning' }} d-flex align-items-center gap-2">
          <i class="ti ti-clock"></i>
          <div>
            <strong>Status Presensi</strong><br>
            {{ $absenMasukSudah ? 'Sudah Absen Masuk' : 'Belum Absen Masuk' }}
          </div>
        </div>

        {{-- PILIH AKSI --}}
        <div class="row g-3 mb-4">
          <div class="col-6">
            <button
              class="btn w-100 py-3 {{ !$absenMasukSudah ? 'btn-primary' : 'btn-outline-secondary' }}"
              data-bs-toggle="collapse"
              data-bs-target="#formMasuk"
              {{ $absenMasukSudah ? 'disabled' : '' }}>
              <i class="ti ti-login fs-3"></i><br>
              <span class="fw-semibold">Absen Masuk</span>
            </button>
          </div>

          <div class="col-6">
            <button
              class="btn w-100 py-3 {{ $absenMasukSudah && !$absenPulangSudah ? 'btn-success' : 'btn-outline-secondary' }}"
              data-bs-toggle="collapse"
              data-bs-target="#formPulang"
              {{ !$absenMasukSudah || $absenPulangSudah ? 'disabled' : '' }}>
              <i class="ti ti-logout fs-3"></i><br>
              <span class="fw-semibold">Absen Pulang</span>
            </button>
          </div>
        </div>

        {{-- FORM MASUK --}}
        <div class="collapse {{ !$absenMasukSudah ? 'show' : '' }}" id="formMasuk">
          <div class="card border shadow-sm mb-3">
            <div class="card-body">
              <h6 class="mb-3 text-primary">
                <i class="ti ti-login"></i> Form Absen Masuk
              </h6>
              @include('magang.presensi._form_masuk')
            </div>
          </div>
        </div>

        {{-- FORM PULANG --}}
        <div class="collapse {{ $absenMasukSudah && !$absenPulangSudah ? 'show' : '' }}" id="formPulang">
          <div class="card border shadow-sm">
            <div class="card-body">
              <h6 class="mb-3 text-success">
                <i class="ti ti-logout"></i> Form Absen Pulang
              </h6>
              @include('magang.presensi._form_pulang')
            </div>
          </div>
        </div>

        {{-- RINGKASAN --}}
        @if($absenMasukSudah || $absenPulangSudah)
          <div class="mt-4 p-3 rounded bg-light">
            <strong>Ringkasan Hari Ini</strong><br>
            Masuk : {{ $jamMasuk ?? '-' }} <br>
            Pulang : {{ $jamPulang ?? '-' }}
          </div>
        @endif

      </div>

    </div>
  </div>
</div>

<script>
function updateClock() {
  const now = new Date(new Date().toLocaleString("en-US", {
    timeZone: "Asia/Jakarta"
  }));

  const hh = String(now.getHours()).padStart(2,'0');
  const mm = String(now.getMinutes()).padStart(2,'0');
  const ss = String(now.getSeconds()).padStart(2,'0');

  const timeString = `${hh}:${mm}:${ss}`;

  // Tampilkan ke UI
  const clockEl = document.getElementById('liveClock');
  if (clockEl) clockEl.textContent = timeString;

  // Inject ke input (jika ada)
  @if(!$absenMasukSudah)
    const masuk = document.getElementById('jamMasuk');
    if (masuk) masuk.value = timeString;
  @endif

  @if(!$absenPulangSudah)
    const pulang = document.getElementById('jamPulang');
    if (pulang) pulang.value = timeString;
  @endif
}

setInterval(updateClock, 1000);
updateClock();
</script>

@endsection
