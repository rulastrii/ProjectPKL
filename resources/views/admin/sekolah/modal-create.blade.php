<!-- Modal Create Sekolah -->
<div class="modal modal-blur fade" id="modalCreateSekolah" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form action="{{ route('admin.sekolah.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Sekolah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama Sekolah -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama Sekolah</label>
            <input type="text" name="nama" class="form-control" placeholder="Enter nama sekolah" value="{{ old('nama') }}" required>
          </div>

          <!-- NPSN -->
          <div class="col-12 col-md-6">
            <label class="form-label">NPSN</label>
            <input type="text" name="npsn" class="form-control" placeholder="Enter NPSN" value="{{ old('npsn') }}" required>
          </div>

          <!-- Alamat -->
          <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" placeholder="Enter alamat sekolah" rows="2" required>{{ old('alamat') }}</textarea>
          </div>

          <!-- Kontak -->
          <div class="col-12 col-md-6">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" placeholder="Enter kontak sekolah" value="{{ old('kontak') }}" required>
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Create Sekolah</button>
      </div>
    </form>
  </div>
</div>
