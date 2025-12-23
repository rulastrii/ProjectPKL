<!-- Sidebar -->
<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <h1 class="navbar-brand navbar-brand-autodark">
      <a href="{{ url('dashboard') }}">
        <img src="{{ asset('img/logo-sipemang.png') }}" alt="SIPemang" class="navbar-brand-image" style="height: 75px; width: auto;">
      </a>
    </h1>

    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link" href="{{ url('dashboard') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-home"></i></span>
            <span class="nav-link-title">Dashboard</span>
          </a>
        </li>

        {{-- ==================== ADMIN (ROLE 1) ==================== --}}
        @if(auth()->user()->role_id == 1)
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-database"></i></span>
            <span class="nav-link-title">Master Data</span>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.sekolah.index') }}"><i class="ti ti-school"></i> Data Sekolah</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="ti ti-user-plus"></i> Data Guru</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.bidang.index') }}"><i class="ti ti-building"></i> Data Bidang</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.pegawai.index') }}"><i class="ti ti-user"></i> Data Pegawai</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.pembimbing.index') }}"><i class="ti ti-user-check"></i> Data Pembimbing</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.siswa.index') }}"><i class="ti ti-users"></i> Data Siswa PKL</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="#"><i class="ti ti-users"></i> Data Mahasiswa Magang</a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.users.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-users"></i></span>
            <span class="nav-link-title">Management Users</span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-file-text"></i></span>
            <span class="nav-link-title">Data Pengajuan</span>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.pengajuan.index') }}"><i class="ti ti-users"></i> Siswa PKL</a>
                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('admin.pengajuan-magang.index') }}"><i class="ti ti-users"></i> Mahasiswa Magang</a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.penempatan.index') }}">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-briefcase"></i></span>
            <span class="nav-link-title">Penempatan Bidang</span>
          </a>
        </li>

        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-calendar"></i></span><span class="nav-link-title">Rekap Presensi</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-file-report"></i></span><span class="nav-link-title">Rekap Laporan</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-chart-pie"></i></span><span class="nav-link-title">Statistik PKL</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-settings"></i></span><span class="nav-link-title">Pengaturan</span></a></li>
        @endif

        {{-- ==================== PEMBIMBING (ROLE 2) ==================== --}}
        @if(auth()->user()->role_id == 2)
        <li class="nav-item"><a class="nav-link" href="{{ route('pembimbing.bimbingan-peserta.index') }}"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-user-check"></i></span><span class="nav-link-title">Siswa Bimbingan</span></a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
            <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-database"></i></span>
            <span class="nav-link-title">Verifikasi</span>
          </a>
          <div class="dropdown-menu">
            <div class="dropdown-menu-columns">
              <div class="dropdown-menu-column">
                <a class="dropdown-item d-flex align-items-center gap-2"
   href="{{ route('pembimbing.verifikasi-presensi.index') }}">
    <i class="ti ti-calendar-time"></i>
    Presensi
</a>

                <a class="dropdown-item d-flex align-items-center gap-2" href="./accordion.html"><i class="ti ti-notes"></i> Laporan Harian</a>
              </div>
            </div>
          </div>
        </li>

        <li class="nav-item"><a class="nav-link" href="{{ route('pembimbing.tugas.index') }}"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-clipboard"></i></span><span class="nav-link-title">Tugas</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-award"></i></span><span class="nav-link-title">Penilaian Akhir</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-file-report"></i></span><span class="nav-link-title">Rekap</span></a></li>
        @endif

        {{-- ==================== GURU (ROLE 3) ==================== --}}
        @if(auth()->user()->role_id == 3)
        <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-list"></i></span><span class="nav-link-title">Pengajuan PKL</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-users"></i></span><span class="nav-link-title">Siswa PKL</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-file-text"></i></span><span class="nav-link-title">Cetak Surat Pengantar</span></a></li>
        @endif

        {{-- ==================== SISWA (ROLE 4) ==================== --}}
        @if(auth()->user()->role_id == 4)
        @php
          $pengajuan = \App\Models\PengajuanPklmagang::where('created_id', auth()->id())->orderByDesc('created_date')->first();
          $isApproved = $pengajuan && $pengajuan->status === 'diterima';
        @endphp
        <li class="nav-item"><a class="nav-link" href="{{ route('siswa.pengajuan.index') }}"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-list"></i></span><span class="nav-link-title">Pengajuan PKL/Magang</span></a></li>

        @if($isApproved)
        <li class="nav-item"><a class="nav-link" href="{{ route('siswa.presensi.index') }}"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-calendar-time"></i></span><span class="nav-link-title">Presensi Harian</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-notebook"></i></span><span class="nav-link-title">Laporan Harian</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-clipboard"></i></span><span class="nav-link-title">Tugas & Evaluasi</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-award"></i></span><span class="nav-link-title">Nilai Akhir & Sertifikat</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-file-text"></i></span><span class="nav-link-title">Riwayat PKL</span></a></li>
        @endif
        @endif

        {{-- ==================== MAGANG (ROLE 5) ==================== --}}
        @if(auth()->user()->role_id == 5)
        <li class="nav-item"><a class="nav-link" href="{{ route('magang.presensi.index') }}"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-calendar-time"></i></span><span class="nav-link-title">Presensi Harian</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-notebook"></i></span><span class="nav-link-title">Laporan Harian</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('magang.tugas.index') }}"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-clipboard"></i></span><span class="nav-link-title">Tugas & Evaluasi</span></a></li>
        <li class="nav-item"><a class="nav-link" href="./form-elements.html"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-award"></i></span><span class="nav-link-title">Nilai Akhir & Sertifikat</span></a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-file-text"></i></span><span class="nav-link-title">Riwayat Magang</span></a></li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('magang.feedback.index') }}">
                <span class="nav-link-icon d-md-none d-lg-inline-block"><i class="ti ti-message-circle"></i></span>
                <span class="nav-link-title">Feedback</span>
            </a>
        </li>
        @endif

      </ul>
    </div>
  </div>
</aside>
<!-- Navbar -->
