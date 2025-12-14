@foreach($pengajuan as $item)
<div class="modal fade" id="modalEditPengajuan-{{ $item->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">

    <form action="{{ route('admin.pengajuan.update',$item->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="modal-content">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Pengajuan PKL/Magang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- No Surat -->
          <div class="col-md-6">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat" class="form-control"
                   value="{{ $item->no_surat }}">
          </div>

          <!-- Tanggal Surat -->
          <div class="col-md-6">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tgl_surat" class="form-control"
                   value="{{ $item->tgl_surat }}">
          </div>

          <!-- Sekolah -->
          <div class="col-md-12">
            <label class="form-label">Asal Sekolah</label>
            <select name="sekolah_id" class="form-select" required>
              <option value="">-- Pilih Sekolah --</option>
              @foreach($sekolahs as $s)
                <option value="{{ $s->id }}"
                    {{ $s->id == $item->sekolah_id ? 'selected' : '' }}>
                  {{ $s->nama_sekolah ?? $s->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Jumlah Siswa -->
          <div class="col-md-6">
            <label class="form-label">Jumlah Siswa</label>
            <input type="number" name="jumlah_siswa" min="1"
                   class="form-control"
                   value="{{ $item->jumlah_siswa }}" required>
          </div>

          <!-- Status -->
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              @foreach(['draft','diproses','diterima','ditolak','selesai'] as $st)
                <option value="{{ $st }}" {{ $item->status == $st ? 'selected' : '' }}>
                  {{ ucfirst($st) }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Periode Mulai -->
          <div class="col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date"
                   name="periode_mulai"
                   id="periode_mulai_{{ $item->id }}"
                   class="form-control"
                   value="{{ $item->periode_mulai }}"
                   required>
          </div>

          <!-- Periode Selesai -->
          <div class="col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date"
                   name="periode_selesai"
                   id="periode_selesai_{{ $item->id }}"
                   class="form-control"
                   value="{{ $item->periode_selesai }}"
                   required>
          </div>

          <!-- Upload Surat -->
          <div class="col-md-12">
            <label class="form-label">Upload Surat (PDF)</label>
            <input type="file"
                   name="file_surat_path"
                   class="form-control"
                   accept="application/pdf"
                   onchange="previewSurat{{ $item->id }}(event)">

            <div class="mt-2">
              <a id="btnPreviewSurat{{ $item->id }}"
                 href="{{ $item->file_surat_path ? asset('uploads/surat/'.$item->file_surat_path) : '#' }}"
                 target="_blank"
                 class="btn btn-sm btn-outline-primary"
                 style="{{ $item->file_surat_path ? '' : 'display:none;' }}">
                Lihat Surat
              </a>
            </div>
          </div>

          <!-- Catatan -->
          <div class="col-md-12">
            <label class="form-label">Catatan</label>
            <textarea name="catatan"
                      class="form-control"
                      rows="3">{{ $item->catatan }}</textarea>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
          Update
        </button>
      </div>

    </form>
  </div>
</div>

{{-- SCRIPT KHUSUS MODAL INI --}}
<script>
(function () {
    const mulai   = document.getElementById('periode_mulai_{{ $item->id }}');
    const selesai = document.getElementById('periode_selesai_{{ $item->id }}');

    // set minimal tanggal selesai saat modal dibuka
    if (mulai.value) {
        selesai.min = mulai.value;
    }

    mulai.addEventListener('change', function () {
        selesai.min = this.value;

        if (selesai.value && selesai.value < this.value) {
            selesai.value = '';
        }
    });
})();

function previewSurat{{ $item->id }}(event){
    const file = event.target.files[0];
    if(file){
        const url = URL.createObjectURL(file);
        const btn = document.getElementById("btnPreviewSurat{{ $item->id }}");
        btn.style.display = "inline-block";
        btn.href = url;
        btn.innerText = "Preview Surat Baru";
    }
}
</script>
@endforeach
