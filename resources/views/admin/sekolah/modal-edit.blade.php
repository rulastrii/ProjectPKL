@foreach($sekolahs as $sekolah)
<!-- Modal Edit Sekolah -->
<div class="modal fade" id="modalEditSekolah-{{ $sekolah->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.sekolah.update', $sekolah->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Sekolah: {{ $sekolah->nama }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama Sekolah -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama Sekolah</label>
            <input type="text" name="nama" class="form-control" value="{{ $sekolah->nama }}" required>
          </div>

          <!-- NPSN -->
          <div class="col-12 col-md-6">
            <label class="form-label">NPSN</label>
            <input type="text" name="npsn" class="form-control" value="{{ $sekolah->npsn }}" required>
          </div>

          <!-- Alamat -->
          <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ $sekolah->alamat }}</textarea>
          </div>

          <!-- Kontak -->
          <div class="col-12 col-md-6">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" value="{{ $sekolah->kontak }}" required>
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $sekolah->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$sekolah->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update Sekolah</button>
      </div>

    </form>
  </div>
</div>
@endforeach
