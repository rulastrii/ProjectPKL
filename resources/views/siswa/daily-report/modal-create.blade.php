<!-- Modal Create Daily Report Siswa PKL -->
<div class="modal fade" id="modalCreateDailyReport" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('siswa.daily-report.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Tambah Laporan Harian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- INFO SISWA (READ ONLY) -->
          <div class="col-12">
            <label class="form-label">Peserta</label>
            <div class="form-control bg-light">
              @php
                $siswa = Auth::user()->siswaProfile;
              @endphp

              @if($siswa)
                <strong>{{ $siswa->nama }}</strong><br>
                {{ $siswa->nisn ?? '-' }} | {{ $siswa->kelas ?? '-' }} | {{ $siswa->jurusan ?? '-' }}
              @else
                <span class="text-danger">Profil siswa belum tersedia</span>
              @endif
            </div>
          </div>

          <!-- Tanggal -->
          <div class="col-md-6">
            <label class="form-label">Tanggal</label>
            <input type="date"
                   name="tanggal"
                   class="form-control"
                   value="{{ date('Y-m-d') }}"
                   required>
          </div>

          <!-- Ringkasan -->
          <div class="col-12">
            <label class="form-label">Ringkasan Kegiatan</label>
            <textarea name="ringkasan"
                      class="form-control"
                      rows="3"
                      placeholder="Apa yang kamu kerjakan hari ini?"
                      required></textarea>
          </div>

          <!-- Kendala -->
          <div class="col-12">
            <label class="form-label">Kendala</label>
            <textarea name="kendala"
                      class="form-control"
                      rows="2"
                      placeholder="Jika ada kendala, tuliskan di sini"></textarea>
          </div>

          <!-- Screenshot -->
          <div class="col-12">
            <label class="form-label">Screenshot</label>
            <input type="file"
                   name="screenshot"
                   class="form-control"
                   accept="image/*"
                   required>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">
          Simpan Laporan
        </button>
      </div>

    </form>
  </div>
</div>
