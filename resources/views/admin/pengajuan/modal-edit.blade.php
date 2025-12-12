@foreach($pengajuan as $item)
<div class="modal fade" id="modalEditPengajuan-{{ $item->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">

    <form action="{{ route('admin.pengajuan.update',$item->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Pengajuan PKL/Magang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- No Surat & Tanggal Surat -->
          <div class="col-md-6">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat" class="form-control" value="{{ $item->no_surat }}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tgl_surat" class="form-control" value="{{ $item->tgl_surat }}">
          </div>

          <!-- Sekolah -->
          <div class="col-md-12">
            <label class="form-label">Asal Sekolah</label>
            <select name="sekolah_id" class="form-select" required>
              <option value="">-- Pilih Sekolah --</option>
              @foreach($sekolahs as $s)
                <option value="{{ $s->id }}" {{ $s->id == $item->sekolah_id ? 'selected':'' }}>
                  {{ $s->nama_sekolah ?? $s->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Jumlah siswa & Status -->
          <div class="col-md-6">
            <label>Jumlah Siswa</label>
            <input type="number" name="jumlah_siswa" class="form-control" value="{{ $item->jumlah_siswa }}">
          </div>

          <div class="col-md-6">
            <label>Status</label>
            <select name="status" class="form-select">
              @foreach(['draft','diproses','diterima','ditolak','selesai'] as $st)
                <option value="{{ $st }}" {{ $item->status == $st ? 'selected':'' }}>
                  {{ ucfirst($st) }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Periode -->
          <div class="col-md-6">
            <label>Periode Mulai</label>
            <input type="date" name="periode_mulai" class="form-control" value="{{ $item->periode_mulai }}" required>
          </div>

          <div class="col-md-6">
            <label>Periode Selesai</label>
            <input type="date" name="periode_selesai" class="form-control" value="{{ $item->periode_selesai }}" required>
          </div>

          <!-- Upload Surat -->
          <div class="col-md-12">
            <label>Upload Surat (PDF)</label>
            <input type="file" name="file_surat_path" class="form-control" accept="application/pdf" onchange="previewSurat{{ $item->id }}(event)">

            <div class="mt-2">
              <a id="btnPreviewSurat{{ $item->id }}"
                href="{{ asset($item->file_surat_path) }}"
                 target="_blank"
                 style="{{ $item->file_surat_path ? '' : 'display:none;' }}">
                {{ $item->file_surat_path ? 'Lihat Surat' : 'Preview Surat Baru' }}
              </a>
            </div>
          </div>

          <!-- Catatan -->
          <div class="col-md-12">
            <label>Catatan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ $item->catatan }}</textarea>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
      </div>

    </form>
  </div>
</div>

<script>
function previewSurat{{ $item->id }}(event){
    let file = event.target.files[0];
    if(file){
        let url = URL.createObjectURL(file);
        let btn = document.getElementById("btnPreviewSurat{{ $item->id }}");
        btn.style.display="inline-block";
        btn.href=url;
        btn.innerText="Preview Surat Baru";
    }
}
</script>
@endforeach
