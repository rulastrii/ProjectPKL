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
          <div class="font-weight-medium">{{ $jumlahLaporanHariIni ?? 0 }}</div>
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
          <div class="font-weight-medium">{{ $jumlahTugasPending }}</div>
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
    <span>{{ $jumlahLaporanHariIni }}/{{ $totalHariMagang }} hari ({{ $totalHariMagang > 0 ? round(($jumlahLaporanHariIni / $totalHariMagang) * 100) : 0 }}%)</span>
  </div>
  <div class="progress" style="height:10px;">
    <div class="progress-bar bg-success" style="width:{{ $totalHariMagang > 0 ? round(($jumlahLaporanHariIni / $totalHariMagang) * 100) : 0 }}%;"></div>
  </div>
</div>



                  <!-- Tugas -->
                  <div class="mb-3">
  <div class="d-flex justify-content-between">
    <span>Tugas</span>
    <span>{{ $tugasSelesai }}/{{ $totalTugas }} selesai ({{ $prosentaseTugas }}%)</span>
  </div>
  <div class="progress" style="height:10px;">
    <div class="progress-bar bg-warning" style="width:{{ $prosentaseTugas }}%;"></div>
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
                @forelse($tugasTerbaru as $tugas)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tugas->judul }}</h5>
                                <p class="card-text">Tenggat: {{ \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y') }}</p>
                               @php
    $submit = $tugas->submits->first();
    if (!$submit) {
        $statusBadge = 'Belum Submit';
        $badgeColor = '#fff9c4';
    } elseif ($submit->status === 'pending') {
        $statusBadge = 'Sudah Submit';
        $badgeColor = '#ffe082';
    } elseif ($submit->status === 'sudah dinilai') {
        $statusBadge = 'Sudah Dinilai';
        $badgeColor = '#c8e6c9';
    } else {
        $statusBadge = 'Belum Submit';
        $badgeColor = '#fff9c4';
    }
    $textColor = '#000';
@endphp

<span class="badge" style="background-color: {{ $badgeColor }}; color: {{ $textColor }}">
    {{ $statusBadge }}
</span>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">
                        Tidak ada tugas terbaru.
                    </div>
                @endforelse
            </div>
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
                        <!-- Card 3: Lihat Semua Tugas -->
<div class="col-md-3 mb-3">
  <div class="card h-100 text-center" style="background-color: #6f42c1; color: white; cursor:pointer;"
       data-bs-toggle="modal" data-bs-target="#tugasModal">
    <div class="card-body d-flex flex-column align-items-center justify-content-center">
      <i class="ti ti-book" style="font-size: 2rem;"></i>
      <h5 class="card-title mt-2">Lihat Semua Tugas</h5>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tugasModal" tabindex="-1" aria-labelledby="tugasModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      
      <!-- Modal Header -->
      <div class="modal-header" style="background-color:#6f42c1; color:white;">
        <h5 class="modal-title" id="tugasModalLabel">Tugas Saya</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <!-- Modal Body -->
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>Judul</th>
                <th>Tenggat</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($tugasTerbaru as $index => $t)
              @php $submit = $t->submits->first(); @endphp
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $t->judul }}</td>
                <td>{{ \Carbon\Carbon::parse($t->tenggat)->format('d M Y') }}</td>
                <td>
    @if(!$submit)
        <span class="badge badge-outline-secondary">Belum Submit</span>
    @elseif($submit->status === 'pending')
        <span class="badge badge-outline-warning">Sudah Submit</span>
    @elseif($submit->status === 'sudah dinilai')
        <span class="badge badge-outline-success">Sudah Dinilai</span>
    @endif
</td>

<td class="text-end">
    @if(!$submit)
        <a href="{{ route('magang.tugas.submitForm', $t->id) }}"
           class="btn btn-sm btn-outline-primary"
           title="Submit Tugas">
            <i class="ti ti-upload"></i>
        </a>

    @elseif($submit->status === 'pending')
        <a href="{{ route('magang.tugas.submitForm', $t->id) }}"
           class="btn btn-sm btn-outline-warning"
           title="Edit Submission">
            <i class="ti ti-edit"></i>
        </a>

    @elseif($submit->status === 'sudah dinilai')
        <a href="{{ route('magang.tugas.show', $t->id) }}"
           class="btn btn-sm btn-outline-success"
           title="Lihat Submission">
            <i class="ti ti-eye"></i>
        </a>
    @endif
</td>

              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">Tidak ada tugas</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>

    </div>
  </div>
</div>



                       <!-- Card: Lihat Penilaian Akhir -->
<div class="col-md-3 mb-3">
    <div class="card h-100 text-center bg-yellow text-white cursor-pointer"
         data-bs-toggle="modal"
         data-bs-target="#modalPenilaianAkhir">
        <div class="card-body d-flex flex-column align-items-center justify-content-center">
            <i class="ti ti-star" style="font-size: 2rem;"></i>
            <h5 class="card-title mt-2">Lihat Penilaian Akhir</h5>
        </div>
    </div>
</div>
<!-- Modal Penilaian Akhir -->
<div class="modal fade" id="modalPenilaianAkhir" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Nilai Akhir PKL / Magang
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                @if(!$penilaian)
                    <div class="alert alert-warning text-center mb-0">
                        Nilai akhir belum tersedia
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-vcenter mb-0">
                            <tbody>
                                <tr>
                                    <th>Nilai Tugas</th>
                                    <td>
                                        {{ $penilaian->nilai_tugas !== null
                                            ? number_format($penilaian->nilai_tugas, 2)
                                            : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nilai Laporan</th>
                                    <td>
                                        {{ $penilaian->nilai_laporan !== null
                                            ? number_format($penilaian->nilai_laporan, 2)
                                            : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nilai Keaktifan</th>
                                    <td>
                                        {{ $penilaian->nilai_keaktifan !== null
                                            ? number_format($penilaian->nilai_keaktifan, 2)
                                            : '-' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nilai Sikap</th>
                                    <td>
                                        {{ $penilaian->nilai_sikap !== null
                                            ? number_format($penilaian->nilai_sikap, 2)
                                            : '-' }}
                                    </td>
                                </tr>

                                {{-- Nilai Akhir muncul hanya jika tugas & laporan sudah ada --}}
                                @if($penilaian->nilai_tugas !== null && $penilaian->nilai_laporan !== null)
                                <tr class="table-success fw-bold">
                                    <th>Nilai Akhir</th>
                                    <td>{{ number_format($penilaian->nilai_akhir, 2) }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>

            <!-- Footer -->
            <div class="modal-footer">

                {{-- Tombol Sertifikat hanya muncul jika nilai lengkap --}}
                @if($penilaian && $penilaian->nilai_tugas !== null && $penilaian->nilai_laporan !== null)
                    <a href="{{ route('magang.sertifikat.index') }}"
                       class="btn btn-primary d-flex align-items-center gap-2">
                        <i class="ti ti-certificate"></i> Lihat Sertifikat
                    </a>
                @endif

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

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
