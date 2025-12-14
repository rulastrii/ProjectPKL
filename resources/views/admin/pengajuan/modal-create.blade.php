<!-- Modal Create Pengajuan -->
<div class="modal modal-blur fade" id="modalCreatePengajuan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">

    <form action="{{ route('admin.pengajuan.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengajuan PKL/Magang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- No Surat -->
          <div class="col-md-6">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat"
                   class="form-control @error('no_surat') is-invalid @enderror"
                   value="{{ old('no_surat') }}" required>
            @error('no_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Tanggal Surat -->
          <div class="col-md-6">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tgl_surat"
                   class="form-control @error('tgl_surat') is-invalid @enderror"
                   value="{{ old('tgl_surat') }}" required>
            @error('tgl_surat') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Sekolah -->
          <div class="col-md-6">
            <label class="form-label">Sekolah</label>
            <select name="sekolah_id"
                    class="form-select @error('sekolah_id') is-invalid @enderror"
                    required>
              <option value="">-- Pilih Sekolah --</option>
              @foreach($sekolahs as $s)
                <option value="{{ $s->id }}" {{ old('sekolah_id') == $s->id ? 'selected' : '' }}>
                  {{ $s->nama }}
                </option>
              @endforeach
            </select>
            @error('sekolah_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Jumlah Siswa -->
          <div class="col-md-6">
            <label class="form-label">Jumlah Siswa</label>
            <input type="number" name="jumlah_siswa" min="1"
                   class="form-control @error('jumlah_siswa') is-invalid @enderror"
                   value="{{ old('jumlah_siswa') }}" required>
            @error('jumlah_siswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Periode Mulai -->
          <div class="col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai" id="periode_mulai"
                   class="form-control @error('periode_mulai') is-invalid @enderror"
                   value="{{ old('periode_mulai') }}" required>
            @error('periode_mulai') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Periode Selesai -->
          <div class="col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai" id="periode_selesai"
                   class="form-control @error('periode_selesai') is-invalid @enderror"
                   value="{{ old('periode_selesai') }}" required>
            @error('periode_selesai') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <!-- Upload Surat -->
          <div class="col-12">
            <label class="form-label">Upload Surat (PDF)</label>
            <input type="file" name="file_surat_path"
                   class="form-control @error('file_surat_path') is-invalid @enderror"
                   accept="application/pdf"
                   onchange="showPDF(event)">
            <small class="text-muted">PDF, max 2MB</small>

            @error('file_surat_path') <div class="invalid-feedback">{{ $message }}</div> @enderror

            <div id="previewButton" class="mt-2" style="display:none;">
              <a id="previewLink" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                Lihat Surat
              </a>
            </div>
          </div>

          <!-- Catatan -->
          <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" rows="3"
                      class="form-control">{{ old('catatan') }}</textarea>
          </div>

          <!-- Status -->
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              <option value="draft">Draft</option>
              <option value="diproses">Diproses</option>
              <option value="diterima">Diterima</option>
              <option value="ditolak">Ditolak</option>
              <option value="selesai">Selesai</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
      </div>

    </form>
  </div>
</div>
<script>
document.getElementById('periode_mulai').addEventListener('change', function () {
    const mulai = this.value;
    const selesai = document.getElementById('periode_selesai');

    // set minimal tanggal selesai = tanggal mulai
    selesai.min = mulai;

    // jika sudah terisi tapi lebih kecil → reset
    if (selesai.value && selesai.value < mulai) {
        selesai.value = '';
    }
});

function showPDF(event){
    const file = event.target.files[0];
    if(file){
        const url = URL.createObjectURL(file);
        document.getElementById("previewLink").href = url;
        document.getElementById("previewButton").style.display = "block";
    }
}
</script>
