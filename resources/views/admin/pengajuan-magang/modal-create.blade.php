<!-- Modal Create Pengajuan Magang Mahasiswa -->
<div class="modal modal-blur fade" id="modalCreatePengajuan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">

    <form action="{{ route('admin.pengajuan-magang.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Tambah Pengajuan Magang Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- No Surat -->
          <div class="col-md-6">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat"
                   class="form-control"
                   value="{{ old('no_surat') }}">
          </div>

          <!-- Tanggal Surat -->
          <div class="col-md-6">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tgl_surat"
                   class="form-control"
                   value="{{ old('tgl_surat') }}">
          </div>

          <!-- Nama Mahasiswa -->
          <div class="col-md-6">
            <label class="form-label">Nama Mahasiswa</label>
            <input type="text" name="nama_mahasiswa"
                   class="form-control"
                   value="{{ old('nama_mahasiswa') }}" required>
          </div>

          <!-- Email Mahasiswa -->
          <div class="col-md-6">
            <label class="form-label">Email Mahasiswa</label>
            <input type="email" name="email_mahasiswa"
                   class="form-control"
                   value="{{ old('email_mahasiswa') }}" required>
          </div>

          <!-- Universitas -->
          <div class="col-md-6">
            <label class="form-label">Universitas</label>
            <input type="text" name="universitas"
                   class="form-control"
                   value="{{ old('universitas') }}" required>
          </div>

          <!-- Jurusan -->
          <div class="col-md-6">
            <label class="form-label">Jurusan</label>
            <input type="text" name="jurusan"
                   class="form-control"
                   value="{{ old('jurusan') }}">
          </div>

          <!-- Periode -->
          <div class="col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai" id="periode_mulai"
                   class="form-control"
                   value="{{ old('periode_mulai') }}" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai" id="periode_selesai"
                   class="form-control"
                   value="{{ old('periode_selesai') }}" required>
          </div>

          <!-- Upload Surat -->
          <div class="col-12">
            <label class="form-label">Upload Surat (PDF)</label>
            <input type="file" name="file_surat_path"
                   class="form-control"
                   accept="application/pdf"
                   onchange="showPDF(event)">
            <div id="previewButton" class="mt-2" style="display:none;">
              <a id="previewLink" href="#" target="_blank"
                 class="btn btn-sm btn-outline-primary">
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
              @foreach(['draft','diproses','diterima','ditolak','selesai'] as $st)
                <option value="{{ $st }}">{{ ucfirst($st) }}</option>
              @endforeach
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary ms-auto">Simpan</button>
      </div>

    </form>
  </div>
</div>


<script>
document.getElementById('periode_mulai').addEventListener('change', function () {
    const mulai = this.value;
    const selesai = document.getElementById('periode_selesai');

    selesai.min = mulai;
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
