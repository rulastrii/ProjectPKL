
          {{-- MASUK --}}
          <div class="tab-pane fade {{ !$absenMasukSudah ? 'show active' : '' }}" id="masuk">
            @if($absenMasukSudah)
              <div class="alert alert-success">Absensi masuk sudah dilakukan.</div>
            @endif

            <form action="{{ route('siswa.presensi.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="tab" value="masuk">

              <div class="mb-3">
                <label>Nama Siswa</label>
                <input class="form-control" readonly value="{{ $siswa->nama }} - {{ $siswa->kelas }} - {{ $siswa->jurusan }}">
              </div>

              <div class="mb-3">
                <label>Tanggal</label>
                <input class="form-control" readonly value="{{ date('Y-m-d') }}">
              </div>

              <div class="mb-3">
                <label>Jam Masuk (Server)</label>
                <input class="form-control" readonly id="jamMasuk" value="{{ $jamMasuk ? \Carbon\Carbon::createFromFormat('H:i:s', $jamMasuk)->format('h:i:s A') : '--:--:-- --' }}">
              </div>

              <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" {{ $absenMasukSudah ? 'disabled' : '' }}>
                  <option value="hadir">Hadir</option>
                  <option value="absen">Absen</option>
                  <option value="sakit">Sakit</option>
                </select>
              </div>

              <div class="mb-3">
                <label>Foto Masuk</label>
                <input type="file" name="foto_masuk" class="form-control" {{ $absenMasukSudah ? 'disabled' : '' }}>
              </div>

              <button class="btn btn-primary" {{ $absenMasukSudah ? 'disabled' : '' }}>Simpan Masuk</button>
            </form>
          </div>

          {{-- PULANG --}}
          <div class="tab-pane fade {{ $absenMasukSudah && !$absenPulangSudah ? 'show active' : '' }}" id="pulang">
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
          </div>

    
<script>
function updateClock() {
  const now = new Date(new Date().toLocaleString("en-US", {timeZone: "Asia/Jakarta"}));
  const h12 = String(now.getHours() % 12 || 12).padStart(2,'0');
  const m = String(now.getMinutes()).padStart(2,'0');
  const s = String(now.getSeconds()).padStart(2,'0');
  const ampm = now.getHours() >= 12 ? 'PM' : 'AM';

  @if(!$absenMasukSudah)
    document.getElementById('jamMasuk').value = `${h12}:${m}:${s} ${ampm}`;
  @endif
  @if(!$absenPulangSudah)
    document.getElementById('jamPulang').value = `${h12}:${m}:${s} ${ampm}`;
  @endif
}

setInterval(updateClock, 1000);
updateClock();
</script>
