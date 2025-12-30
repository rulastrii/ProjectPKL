@php
use Carbon\Carbon;

$sekarang = Carbon::now();
$jamMasukNormal = Carbon::createFromTime(11, 0, 0);

$telatMasuk = $sekarang->gt($jamMasukNormal) && !$absenMasukSudah;
$sudahLewatMasuk = $sekarang->gt($jamMasukNormal);
@endphp

@if($absenMasukSudah)
  <div class="alert alert-success">
    Absensi masuk sudah dilakukan.
  </div>
@elseif($telatMasuk)
  <div class="alert alert-danger">
    Anda telat absen masuk!
  </div>
@endif

<form action="{{ route('siswa.presensi.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="tab" value="masuk">

  <div class="mb-3">
    <label>Nama Siswa</label>
    <input class="form-control" readonly
           value="{{ $siswa->nama }} - {{ $siswa->kelas ?? '-' }} - {{ $siswa->jurusan ?? '-' }}">
  </div>

  <div class="mb-3">
    <label>Tanggal</label>
    <input class="form-control" readonly value="{{ date('Y-m-d') }}">
  </div>

  <div class="mb-3">
    <label>Jam Masuk (Server)</label>
    <input class="form-control" readonly
           id="jamMasuk"
           value="{{ $jamMasuk
              ? Carbon::createFromFormat('H:i:s', $jamMasuk)->format('H:i:s')
              : '--:--:--' }}">
  </div>

  <div class="mb-3">
    <label>Status</label>
    <input type="text" class="form-control" value="Hadir" readonly>
    <input type="hidden" name="status" value="hadir">
  </div>

  <div class="mb-3">
    <label>Foto Masuk</label>
    <input type="file" name="foto_masuk" class="form-control"
           {{ $absenMasukSudah || $sudahLewatMasuk ? 'disabled' : '' }}>
  </div>

  <button type="submit" class="btn btn-primary"
          {{ $absenMasukSudah || $sudahLewatMasuk ? 'disabled' : '' }}>
    Simpan Masuk
  </button>
</form>
