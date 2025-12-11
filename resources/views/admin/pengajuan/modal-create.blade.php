<!-- Modal Create Pengajuan -->
<div class="modal modal-blur fade" id="modalCreatePengajuan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

    <form action="{{ route('admin.pengajuan.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengajuan PKL/Magang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- No Surat -->
          <div class="col-12 col-md-6">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat" class="form-control" placeholder="Masukkan nomor surat"
                value="{{ old('no_surat') }}" required>
          </div>

          <!-- Tanggal Surat -->
          <div class="col-12 col-md-6">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tgl_surat" class="form-control" value="{{ old('tgl_surat') }}" required>
          </div>

          <!-- Sekolah -->
          <div class="col-12 col-md-6">
            <label class="form-label">Sekolah</label>
            <select name="sekolah_id" class="form-select" required>
              <option value="">-- Pilih Sekolah --</option>
              @foreach($sekolahs as $s)
                <option value="{{ $s->id }}" {{ old('sekolah_id') == $s->id ? 'selected' : '' }}>
                  {{ $s->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Jumlah Siswa -->
          <div class="col-12 col-md-6">
            <label class="form-label">Jumlah Siswa</label>
            <input type="number" name="jumlah_siswa" class="form-control" min="1"
                placeholder="Masukkan jumlah" value="{{ old('jumlah_siswa') }}" required>
          </div>

          <!-- Periode Mulai -->
          <div class="col-12 col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai" class="form-control" value="{{ old('periode_mulai') }}" required>
          </div>

          <!-- Periode Selesai -->
          <div class="col-12 col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai" class="form-control" value="{{ old('periode_selesai') }}" required>
          </div>

          <!-- Upload File Surat -->
<div class="col-12">
    <label class="form-label">Upload Surat (PDF)</label>
    <input type="file" name="file_surat_path" class="form-control" accept="application/pdf" required onchange="showPDF(event)">
    <small class="form-hint text-muted">Format PDF max 2MB</small>

    <!-- Tombol Lihat/Preview muncul setelah pilih file -->
    <div id="previewButton" style="display:none;" class="mt-2">
        <a id="previewLink" href="#" target="_blank">
            Lihat Surat
        </a>
    </div>
</div>


          <!-- Catatan -->
          <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
          </div>

          <!-- Status -->
          <div class="col-12 col-md-6">
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
function showPDF(event){
    let file = event.target.files[0];
    if(file){
        let url = URL.createObjectURL(file); // menghasilkan blob URL
        document.getElementById("previewLink").href = url;
        document.getElementById("previewButton").style.display = "block";
    }
}
</script>