@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">

            <!-- Cards Statistik -->
            <div class="col-12 mb-3">
                <div class="row row-cards row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-3">

                    <!-- Card 1: Total Pengajuan Masuk -->
                    <div class="col">
                        <div class="card card-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <span class="avatar bg-primary text-white me-3 d-flex justify-content-center align-items-center" style="width:48px;height:48px;">
                                    <i class="ti ti-file-text" style="font-size:24px;"></i>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="font-weight-medium">{{ $totalPengajuan }}</div>
                                    <div class="text-secondary">Total Pengajuan Masuk</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2: Menunggu Verifikasi -->
                    <div class="col">
                        <div class="card card-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <span class="avatar bg-yellow text-white me-3 d-flex justify-content-center align-items-center" style="width:48px;height:48px;">
                                    <i class="ti ti-clock" style="font-size:24px;"></i>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="font-weight-medium">{{ $menungguVerifikasi }}</div>
                                    <div class="text-secondary">Menunggu Verifikasi</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3: Total Peserta Aktif -->
                    <div class="col">
                        <div class="card card-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <span class="avatar bg-green text-white me-3 d-flex justify-content-center align-items-center" style="width:48px;height:48px;">
                                    <i class="ti ti-users" style="font-size:24px;"></i>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="font-weight-medium">{{ $totalPeserta }}</div>
                                    <div class="text-secondary">Total Peserta Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: Total Pembimbing Aktif -->
                    <div class="col">
                        <div class="card card-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <span class="avatar bg-purple text-white me-3 d-flex justify-content-center align-items-center" style="width:48px;height:48px;">
                                    <i class="ti ti-user-check" style="font-size:24px;"></i>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="font-weight-medium">{{ $totalPembimbing }}</div>
                                    <div class="text-secondary">Total Pembimbing Aktif</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 5: Total Bidang -->
                    <div class="col">
                        <div class="card card-sm h-100">
                            <div class="card-body d-flex align-items-center">
                                <span class="avatar bg-red text-white me-3 d-flex justify-content-center align-items-center" style="width:48px;height:48px;">
                                    <i class="ti ti-building" style="font-size:24px;"></i>
                                </span>
                                <div class="flex-grow-1">
                                    <div class="font-weight-medium">{{ $totalBidang }}</div>
                                    <div class="text-secondary">Total Bidang</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Charts -->
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title">Jumlah Peserta PKL per Bulan</h3>
                        <canvas id="chartPeserta" class="chart-lg"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h3 class="card-title">Jumlah Peserta Per Bidang</h3>
                    <div id="chart-mentions" class="chart-lg"></div>
                  </div>
                </div>
              </div>

            <!-- Pengajuan Terbaru -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h3 class="card-title">Pengajuan Terbaru</h3>
                        <div class="ms-auto d-flex gap-2">
                            <a href="{{ route('admin.pengajuan.index') }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-plus me-1"></i> Tambah Pengajuan
                            </a>
                            <a href="{{ route('admin.sekolah.index') }}" class="btn btn-success btn-sm">
                                <i class="ti ti-plus me-1"></i> Tambah Data Sekolah
                            </a>
                            <a href="{{ route('admin.pembimbing.index') }}" class="btn btn-purple btn-sm">
                                <i class="ti ti-plus me-1"></i> Tambah Data Pembimbing
                            </a>
                        </div>
                    </div>

                    <div class="card-body border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                Show
                                <input type="number" class="form-control form-control-sm" value="5" style="width: 60px;">
                                entries
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                Search:
                                <input type="text" class="form-control form-control-sm" placeholder="Cari...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table card-table table-vcenter table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No. Surat</th>
                                    <th>Sekolah</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pengajuanTerbaru as $pengajuan)
                                    <tr>
                                        <td>{{ $pengajuan['no_surat'] }}</td>
                                        <td>{{ $pengajuan['sekolah'] }}</td>
                                        <td>{{ $pengajuan['periode'] }}</td>
                                        <td>
                                            @php
                                                $status = $pengajuan['status'];
                                                $class = match(strtolower($status)) {
                                                    'draft' => 'text-secondary',
                                                    'diproses' => 'text-warning',
                                                    'diterima' => 'text-success',
                                                    'ditolak' => 'text-danger',
                                                    default => 'text-secondary'
                                                };
                                            @endphp
                                            <span class="{{ $class }} fw-semibold">{{ $status }}</span>
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ $pengajuan['type'] == 'magang' 
                                                ? route('admin.pengajuan.show', $pengajuan['id']) 
                                                : route('admin.pengajuan.show', $pengajuan['id']) }}" 
                                                class="btn btn-outline-primary btn-sm">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer d-flex align-items-center">
                        <p class="m-0 text-secondary">Showing 1 to 5 of {{ count($pengajuanTerbaru) }} entries</p>
                        <ul class="pagination m-0 ms-auto">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">prev</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">next</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Peserta PKL per Bulan
    const ctx = document.getElementById('chartPeserta').getContext('2d');
    const chartPeserta = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Peserta PKL',
                data: @json($chartData),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    precision:0
                }
            }
        }
    });

</script>
@endsection
