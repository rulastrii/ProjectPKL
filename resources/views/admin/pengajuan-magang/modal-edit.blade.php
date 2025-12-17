@foreach($pengajuan as $item)
<div class="modal fade" id="modalEditPengajuan-{{ $item->id }}" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">

    <form action="{{ route('admin.pengajuan-magang.update', $item->id) }}"
          method="POST"
          enctype="multipart/form-data"
          class="modal-content">
      @csrf
      @method('PUT')

      <div class="modal-header">
        <h5 class="modal-title">Edit Pengajuan Magang Mahasiswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- No Surat -->
          <div class="col-md-6">
            <label class="form-label">No Surat</label>
            <input type="text" name="no_surat"
                   class="form-control"
                   value="{{ $item->no_surat }}">
          </div>

          <!-- Tanggal Surat (FIX STRING) -->
          <div class="col-md-6">
            <label class="form-label">Tanggal Surat</label>
            <input type="date" name="tgl_surat"
                   class="form-control"
                   value="{{ $item->tgl_surat ? \Carbon\Carbon::parse($item->tgl_surat)->format('Y-m-d') : '' }}">
          </div>

          <!-- Nama -->
          <div class="col-md-6">
            <label class="form-label">Nama Mahasiswa</label>
            <input type="text" name="nama_mahasiswa"
                   class="form-control"
                   value="{{ $item->nama_mahasiswa }}" required>
          </div>

          <!-- Email -->
          <div class="col-md-6">
            <label class="form-label">Email Mahasiswa</label>
            <input type="email" name="email_mahasiswa"
                   class="form-control"
                   value="{{ $item->email_mahasiswa }}" required>
          </div>

          <!-- Universitas -->
          <div class="col-md-6">
            <label class="form-label">Universitas</label>
            <input type="text" name="universitas"
                   class="form-control"
                   value="{{ $item->universitas }}" required>
          </div>

          <!-- Jurusan -->
          <div class="col-md-6">
            <label class="form-label">Jurusan</label>
            <input type="text" name="jurusan"
                   class="form-control"
                   value="{{ $item->jurusan }}">
          </div>

          <!-- Periode -->
          <div class="col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai"
                   class="form-control"
                   value="{{ \Carbon\Carbon::parse($item->periode_mulai)->format('Y-m-d') }}">
          </div>

          <div class="col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai"
                   class="form-control"
                   value="{{ \Carbon\Carbon::parse($item->periode_selesai)->format('Y-m-d') }}">
          </div>

          <!-- Upload -->
          <div class="col-12">
            <label class="form-label">Upload Surat</label>
            <input type="file" name="file_surat_path"
                   class="form-control"
                   accept="application/pdf"
                   onchange="previewSurat{{ $item->id }}(event)">

            @if($item->file_surat_path)
              <a id="btnPreviewSurat{{ $item->id }}"
                 href="{{ asset('uploads/surat/'.$item->file_surat_path) }}"
                 target="_blank"
                 class="btn btn-sm btn-outline-primary mt-2">
                Lihat Surat
              </a>
            @endif
          </div>

          <!-- Catatan -->
          <div class="col-12">
            <label class="form-label">Catatan</label>
            <textarea name="catatan" class="form-control" rows="3">{{ $item->catatan }}</textarea>
          </div>

          <!-- Status -->
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
              @foreach(['draft','diproses','diterima','ditolak','selesai'] as $st)
                <option value="{{ $st }}" {{ $item->status==$st?'selected':'' }}>
                  {{ ucfirst($st) }}
                </option>
              @endforeach
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-primary">Update</button>
      </div>

    </form>
  </div>
</div>


{{-- SCRIPT KHUSUS MODAL --}}
<script>
(function () {
    const mulai   = document.getElementById('periode_mulai_{{ $item->id }}');
    const selesai = document.getElementById('periode_selesai_{{ $item->id }}');

    if (mulai.value) selesai.min = mulai.value;

    mulai.addEventListener('change', function () {
        selesai.min = this.value;
        if (selesai.value && selesai.value < this.value) selesai.value = '';
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
