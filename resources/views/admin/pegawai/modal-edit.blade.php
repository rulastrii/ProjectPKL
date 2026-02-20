@foreach($pegawais as $pegawai)
<!-- Modal Edit Pegawai -->
<div class="modal fade" id="modalEditPegawai-{{ $pegawai->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.pegawai.update', $pegawai->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Pegawai: {{ $pegawai->nama }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- NIP -->
          <div class="col-12 col-md-6">
            <label class="form-label">NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ $pegawai->nip }}" required>
          </div>

          <!-- Nama -->
          <div class="col-12 col-md-6">
            <label class="form-label">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $pegawai->nama }}" required>
          </div>

          <!-- Jabatan -->
          <div class="col-12 col-md-6">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ $pegawai->jabatan }}">
          </div>

          <!-- Bidang -->
          <div class="col-12 col-md-6">
            <label class="form-label">Bidang</label>
            <select name="bidang_id" class="form-select">
              <option value="">-- Select Bidang --</option>
              @foreach($bidangs as $bidang)
                <option value="{{ $bidang->id }}" {{ $pegawai->bidang_id == $bidang->id ? 'selected' : '' }}>
                  {{ $bidang->nama }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $pegawai->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$pegawai->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update Pegawai</button>
      </div>

    </form>
  </div>
</div>
@endforeach
