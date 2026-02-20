<div class="card">
  <div class="card-header">
    <h3 class="card-title">Tambah Presensi Hari Ini</h3>
  </div>
  <div class="card-body">

    @php
      $jamMasuk = $todayPresensi?->jam_masuk;
      $jamPulang = $todayPresensi?->jam_keluar;
      $absenMasukSudah = !is_null($jamMasuk);
      $absenPulangSudah = !is_null($jamPulang);
    @endphp

    @if($absenMasukSudah || $absenPulangSudah)
      <div class="alert alert-info">
        <strong>Status Hari Ini</strong><br>
        Masuk : {{ $jamMasuk ?? '-' }} <br>
        Pulang : {{ $jamPulang ?? '-' }}
      </div>
    @endif

    {{-- Tombol Tab Horizontal --}}
    <div class="d-flex border-bottom mb-3" role="tablist">
      <button class="btn btn-outline-primary me-2 tab-toggle {{ !$absenMasukSudah ? 'active' : '' }}" 
              data-target="#collapseMasuk">Absen Masuk</button>
      <button class="btn btn-outline-primary tab-toggle {{ $absenMasukSudah && !$absenPulangSudah ? 'active' : '' }}" 
              data-target="#collapsePulang">Absen Pulang</button>
    </div>

    <div class="accordion">
      {{-- Masuk --}}
      <div id="collapseMasuk" class="accordion-collapse collapse {{ !$absenMasukSudah ? 'show' : '' }}">
        <div class="accordion-body">
          @include('siswa.presensi._form_masuk')
        </div>
      </div>

      {{-- Pulang --}}
      <div id="collapsePulang" class="accordion-collapse collapse {{ $absenMasukSudah && !$absenPulangSudah ? 'show' : '' }}">
        <div class="accordion-body">
          @include('siswa.presensi._form_pulang')
        </div>
      </div>
    </div>

  </div>
</div>

{{-- JavaScript untuk toggle tab --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
  const toggles = document.querySelectorAll('.tab-toggle');
  toggles.forEach(btn => {
    btn.addEventListener('click', function() {
      const target = document.querySelector(this.dataset.target);
      const allCollapses = document.querySelectorAll('.accordion-collapse');
      allCollapses.forEach(c => { if(c !== target) c.classList.remove('show'); });
      target.classList.toggle('show');
      toggles.forEach(b => b.classList.remove('active'));
      if(target.classList.contains('show')) this.classList.add('active');
    });
  });
});

// Jam otomatis update
function updateClock() {
  const now = new Date(new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" }));
  const h = String(now.getHours()).padStart(2,'0');
  const m = String(now.getMinutes()).padStart(2,'0');
  const s = String(now.getSeconds()).padStart(2,'0');
  const timeString = `${h}:${m}:${s}`;

  @if(!$absenMasukSudah)
    const masuk = document.getElementById('jamMasuk');
    if(masuk) masuk.value = timeString;
  @endif

  @if(!$absenPulangSudah)
    const pulang = document.getElementById('jamPulang');
    if(pulang) pulang.value = timeString;
  @endif
}

setInterval(updateClock, 1000);
updateClock();
</script>
