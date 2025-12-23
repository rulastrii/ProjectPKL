@php

use Carbon\Carbon;
$sekarang = Carbon::now();

$jamPulangNormal = Carbon::createFromTimeString('17:00:00');
$sudahLewatPulang = $sekarang->gt($jamPulangNormal);
@endphp

@if($absenPulangSudah)
  <div class="alert alert-success">
    Absensi pulang sudah dilakukan.
  </div>
@elseif(!$absenMasukSudah)
  <div class="alert alert-warning">
    Anda belum absen masuk.<br>
    <strong>Presensi akan tercatat sebagai Absen Tidak Lengkap.</strong>
  </div>
@elseif($sudahLewatPulang && !$absenPulangSudah)
  <div class="alert alert-danger">
    Anda melewati jam pulang!
  </div>
@endif

<form action="{{ route('magang.presensi.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="tab" value="pulang">

  <div class="mb-3">
    <label>Tanggal</label>
    <input class="form-control" readonly value="{{ date('Y-m-d') }}">
  </div>

  <div class="mb-3">
    <label>Jam Pulang (Server)</label>
    <input class="form-control"
           readonly
           id="jamPulang"
           value="{{ $jamPulang
              ? \Carbon\Carbon::createFromFormat('H:i:s', $jamPulang)->format('H:i:s')
              : '--:--:--' }}">
  </div>

  <div class="mb-3">
    <label>Foto Pulang</label>
    <input type="file" name="foto_pulang" class="form-control"
           {{ $absenPulangSudah || $sudahLewatPulang ? 'disabled' : '' }}>
  </div>

  <button class="btn btn-success"
          {{ $absenPulangSudah || $sudahLewatPulang ? 'disabled' : '' }}>
    Simpan Pulang
  </button>
</form>
