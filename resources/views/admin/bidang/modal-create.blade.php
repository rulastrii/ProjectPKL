<!-- Modal Create Bidang -->
<div class="modal modal-blur fade" id="modalCreateBidang" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form action="{{ route('admin.bidang.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Bidang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama Bidang -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama Bidang</label>
            <input type="text" name="nama" class="form-control" placeholder="Enter nama bidang" value="{{ old('nama') }}" required>
          </div>

          <!-- Kode Bidang -->
          <div class="col-12 col-md-6">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" placeholder="Enter kode bidang" value="{{ old('kode') }}">
          </div>

          <!-- Status Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ old('is_active') === '1' ? 'selected' : '' }}>Active</option>
              <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Create Bidang</button>
      </div>
    </form>
  </div>
</div>
