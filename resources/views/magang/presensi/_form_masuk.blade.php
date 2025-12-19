@if($absenMasukSudah)
  <div class="alert alert-success">Absensi masuk sudah dilakukan.</div>
@endif

<form action="{{ route('magang.presensi.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="hidden" name="tab" value="masuk">

  <div class="mb-3">
    <label>Nama Magang</label>
    <input class="form-control" readonly value="{{ $magang->nama }} - {{ $magang->jurusan }} - {{ $magang->universitas }}">
  </div>

  <div class="mb-3">
    <label>Tanggal</label>
    <input class="form-control" readonly value="{{ date('Y-m-d') }}">
  </div>

  <div class="mb-3">
    <label>Jam Masuk (Server)</label>
    <input class="form-control" readonly id="jamMasuk" value="{{ $jamMasuk ? \Carbon\Carbon::createFromFormat('H:i:s', $jamMasuk)->format('H:i:s') : '--:--:-- --' }}">
  </div>

  <div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-select" {{ $absenMasukSudah ? 'disabled' : '' }}>
      <option value="hadir">Hadir</option>
      <option value="izin">Izin</option>
      <option value="sakit">Sakit</option>
      <option value="absen">Absen</option>
    </select>
  </div>

  <div class="mb-3">
    <label>Foto Masuk</label>
    <input type="file" name="foto_masuk" class="form-control" {{ $absenMasukSudah ? 'disabled' : '' }}>
  </div>

  <button class="btn btn-primary" {{ $absenMasukSudah ? 'disabled' : '' }}>Simpan Masuk</button>
</form>
