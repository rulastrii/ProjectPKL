@foreach($reports as $report)
<!-- Modal Edit Daily Report Siswa PKL -->
<div class="modal fade"
     id="modalEditDailyReport-{{ $report->id }}"
     tabindex="-1"
     aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('siswa.daily-report.update', $report->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="modal-content">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">
          Edit Laporan — {{ $report->tanggal }}
        </h5>
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
                   value="{{ $report->tanggal }}"
                   required>
          </div>

          <!-- Ringkasan -->
          <div class="col-12">
            <label class="form-label">Ringkasan Kegiatan</label>
            <textarea name="ringkasan"
                      class="form-control"
                      rows="3"
                      required>{{ $report->ringkasan }}</textarea>
          </div>

          <!-- Kendala -->
          <div class="col-12">
            <label class="form-label">Kendala</label>
            <textarea name="kendala"
                      class="form-control"
                      rows="2">{{ $report->kendala }}</textarea>
          </div>

          <!-- Screenshot -->
          <div class="col-12">
            <label class="form-label">Screenshot</label>

            @if($report->screenshot)
              <div class="mb-2">
                <a href="{{ asset('uploads/daily-report/'.$report->screenshot) }}"
                   target="_blank"
                   class="btn btn-outline-secondary btn-sm"
                   required>
                  Lihat Screenshot
                </a>
              </div>
            @endif

            <input type="file"
                   name="screenshot"
                   class="form-control"
                   accept="image/*">
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">
          Update Laporan
        </button>
      </div>

    </form>
  </div>
</div>
@endforeach
