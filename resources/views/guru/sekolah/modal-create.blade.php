<!-- Modal Create Sekolah -->
<div class="modal modal-blur fade" id="modalCreateSekolah" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form action="{{ route('guru.sekolah.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Sekolah Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama Sekolah -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama Sekolah</label>
            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama sekolah" value="{{ old('nama') }}" required>
          </div>

          <!-- NPSN -->
          <div class="col-12 col-md-6">
            <label class="form-label">NPSN</label>
            <input type="text" name="npsn" class="form-control" placeholder="Masukkan NPSN" value="{{ old('npsn') }}">
          </div>

          <!-- Alamat -->
          <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" placeholder="Masukkan alamat sekolah" rows="2">{{ old('alamat') }}</textarea>
          </div>

          <!-- Kontak -->
          <div class="col-12 col-md-6">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" placeholder="Masukkan kontak sekolah" value="{{ old('kontak') }}">
          </div>

          <!-- Status -->
          <div class="col-12 col-md-6">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
              <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Tambah Sekolah</button>
      </div>
    </form>
  </div>
</div>
