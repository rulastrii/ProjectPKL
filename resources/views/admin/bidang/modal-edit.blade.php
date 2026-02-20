@foreach($bidangs as $bidang)
<!-- Modal Edit Bidang -->
<div class="modal fade" id="modalEditBidang-{{ $bidang->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.bidang.update', $bidang->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Bidang: {{ $bidang->nama }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Nama Bidang -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama Bidang</label>
            <input type="text" name="nama" class="form-control" value="{{ $bidang->nama }}" required>
          </div>

          <!-- Kode Bidang -->
          <div class="col-12 col-md-6">
            <label class="form-label">Kode</label>
            <input type="text" name="kode" class="form-control" value="{{ $bidang->kode }}">
          </div>

          <!-- Status Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $bidang->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$bidang->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update Bidang</button>
      </div>
    </form>
  </div>
</div>
@endforeach
