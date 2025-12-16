@if(!$absenMasukSudah)
  <div class="alert alert-warning">Anda belum absen masuk.</div>
@elseif($absenPulangSudah)
  <div class="alert alert-success">Absensi pulang sudah dilakukan.</div>
@endif

<form action="{{ route('siswa.presensi.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="tab" value="pulang">

  <div class="mb-3">
    <label>Tanggal</label>
    <input class="form-control" readonly value="{{ date('Y-m-d') }}">
  </div>

  <div class="mb-3">
    <label>Jam Pulang (Server)</label>
    <input class="form-control" readonly id="jamPulang" value="{{ $jamPulang ? \Carbon\Carbon::createFromFormat('H:i:s', $jamPulang)->format('h:i:s A') : '--:--:-- --' }}">
  </div>

  <div class="mb-3">
    <label>Foto Pulang</label>
    <input type="file" name="foto_pulang" class="form-control" {{ $absenPulangSudah || !$absenMasukSudah ? 'disabled' : '' }}>
  </div>

  <button class="btn btn-success" {{ $absenPulangSudah || !$absenMasukSudah ? 'disabled' : '' }}>Simpan Pulang</button>
</form>
