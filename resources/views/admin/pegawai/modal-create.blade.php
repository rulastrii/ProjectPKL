<!-- Modal Create Pegawai -->
<div class="modal modal-blur fade" id="modalCreatePegawai" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form action="{{ route('admin.pegawai.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- NIP -->
          <div class="col-12 col-md-6">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" placeholder="Enter NIP" value="{{ old('nip') }}" required>
          </div>

          <!-- Nama -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" placeholder="Enter name" value="{{ old('nama') }}" required>
          </div>

          <!-- Jabatan -->
          <div class="col-12 col-md-6">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" placeholder="Enter jabatan" value="{{ old('jabatan') }}">
          </div>

          <!-- Bidang -->
          <div class="col-12 col-md-6">
            <label class="form-label">Bidang</label>
            <select name="bidang_id" class="form-select">
              <option value="">-- Select Bidang --</option>
              @foreach($bidangs as $bidang)
                <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected':'' }}>
                  {{ $bidang->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ old('is_active',1) == 1 ? 'selected':'' }}>Active</option>
              <option value="0" {{ old('is_active') == 0 ? 'selected':'' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Create Pegawai</button>
      </div>
    </form>
  </div>
</div>
