@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<div class="page-body">
  <div class="container-xl">

  {{-- Notifikasi Compact --}}
@php
    $messages = [];

    if($notifData['draft']) {
        $messages[] = $notifData['draft'] . ' siswa masih draft';
    }
    if($notifData['diproses']) {
        $messages[] = $notifData['diproses'] . ' siswa sedang diproses';
    }
    if($notifData['diterima']) {
        $messages[] = $notifData['diterima'] . ' siswa PKL telah diterima';
    }
    if($notifData['ditolak']) {
        $messages[] = $notifData['ditolak'] . ' siswa PKL ditolak';
    }
    if($notifData['selesai']) {
        $messages[] = $notifData['selesai'] . ' siswa PKL sudah selesai';
    }
    if($soonEnding) {
        $messages[] = $soonEnding . ' siswa akan segera selesai PKL';
    }
@endphp

@if(count($messages))
    <div class="alert alert-info">
        {{ implode(', ', $messages) }}.
    </div>
@endif


    {{-- Statistik & Quick Action --}}
    <div class="row row-deck row-cards">

      <!-- Total Siswa Bimbingan -->
      <div class="col-md-3">
        <div class="card card-sm h-100">
          <div class="card-body d-flex align-items-center">
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

      <!-- Siswa Diterima -->
      <div class="col-md-3">
        <div class="card card-sm h-100">
          <div class="card-body d-flex align-items-center">
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

      <!-- Siswa Ditolak -->
      <div class="col-md-3">
        <div class="card card-sm h-100">
          <div class="card-body d-flex align-items-center">
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

      <!-- Quick Action Ajukan Siswa Baru -->
      <div class="col-md-3">
        <div class="card card-sm h-100">
          <div class="card-body d-flex align-items-center">
            
            <!-- Ikon -->
            <span class="bg-yellow text-white avatar me-3">
              <i class="ti ti-user-plus fs-1"></i>
            </span>
            
            <!-- Konten -->
            <div>
              <div class="h3 mb-0">
                <a href="{{ route('guru.pengajuan.create') }}" class="btn btn-primary btn-sm text-white">
                  <i class="ti ti-plus me-1"></i> Ajukan
                </a>
              </div>
              <div class="text-secondary">Ajukan Siswa Baru</div>
            </div>

          </div>
        </div>
      </div>


    </div>

    {{-- Grafik Bar Status per Bulan --}}
      <div class="row row-deck mt-4 g-3"> <!-- g-3 untuk jarak antar card -->
        
        <!-- Bar Chart -->
        <div class="col-lg-8 d-flex">
          <div class="card flex-fill"> <!-- flex-fill supaya card ikut tinggi row -->
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Jumlah Siswa Diterima / Ditolak per Bulan</h5>
              <div class="flex-fill"> <!-- flex-fill supaya canvas stretch -->
                <canvas id="chartStatusPerBulan"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-lg-4 d-flex">
          <div class="card flex-fill">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Status Siswa Bimbingan</h5>
              <div class="flex-fill">
                <canvas id="chartStatusPie"></canvas>
              </div>
            </div>
          </div>
        </div>

      </div>


    {{-- Tabel Daftar Siswa --}}
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Daftar Siswa Bimbingan</h5>
            <input type="text" id="searchSiswa" class="form-control mb-3" placeholder="Cari nama / status siswa...">
            <div class="table-responsive">
              <table class="table table-bordered" id="tableSiswa">
                <thead>
                  <tr>
                    <th>Nama Siswa</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Periode PKL</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($siswaList as $siswa)
                  <tr>
                    <td>{{ $siswa->nama_siswa }}</td>
                    <td>{{ $siswa->email_siswa }}</td>
                    <td>{{ ucfirst($siswa->status) }}</td>
                    <td>
    {{ $siswa->pengajuan->periode_mulai?->format('M Y') ?? '-' }}
    -
    {{ $siswa->pengajuan->periode_selesai?->format('M Y') ?? '-' }}
</td>

                    <td>
                      <a href="{{ route('guru.siswa.show', $siswa->id) }}" class="btn btn-info btn-sm">Lihat Detail</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartStatusPerBulan').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($bulanLabels),
        datasets: [
            {
                label: 'Diterima',
                data: @json(array_values($diterimaData)),
                backgroundColor: 'rgba(54, 162, 235, 0.4)', // biru pastel
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            },
            {
                label: 'Ditolak',
                data: @json(array_values($ditolakData)),
                backgroundColor: 'rgba(255, 99, 132, 0.4)', // merah pastel
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Jumlah Siswa Diterima / Ditolak per Bulan'
            }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// Pie Chart
const ctxPie = document.getElementById('chartStatusPie').getContext('2d');
new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: ['Diterima', 'Ditolak', 'Diproses'],
        datasets: [{
            data: [{{ $pengajuanDisetujui }}, {{ $pengajuanDitolak }}, {{ $pengajuanDiproses }}],
            backgroundColor: [
                'rgba(54, 162, 235, 0.9)', // biru solid
                'rgba(255, 99, 132, 0.9)', // merah solid
                'rgba(255, 206, 86, 0.9)'  // kuning solid
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: { 
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            },
            title: {
                display: true,
                text: 'Distribusi Status Siswa Bimbingan'
            }
        }
    }
});


// Simple filter/search
document.getElementById('searchSiswa').addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#tableSiswa tbody tr');
    rows.forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(filter) ? '' : 'none';
    });
});
</script>

@endsection
