@foreach($pembimbing as $b)
<!-- Modal Edit Pembimbing -->
<div class="modal fade" id="modalEditPembimbing-{{ $b->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('admin.pembimbing.update', $b->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Pembimbing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <!-- Pengajuan -->
          <div class="col-12 col-md-6">
            <label class="form-label">Pengajuan</label>
            <select name="pengajuan_id" class="form-select" required>
              @foreach($pengajuan as $p)
                <option value="{{ $p->id }}" {{ $b->pengajuan_id == $p->id ? 'selected':'' }}>
                  {{ $p->no_surat }} - {{ $p->sekolah->nama ?? '-' }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Pegawai -->
          <div class="col-12 col-md-6">
            <label class="form-label">Pembimbing</label>
            <select name="pegawai_id" class="form-select" required>
              @foreach($pegawai as $peg)
                <option value="{{ $peg->id }}" {{ $b->pegawai_id == $peg->id ? 'selected':'' }}>{{ $peg->nama }}</option>
              @endforeach
            </select>
          </div>

          <!-- Tahun -->
          <div class="col-12 col-md-6">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" value="{{ $b->tahun }}">
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $b->is_active ? 'selected':'' }}>Active</option>
              <option value="0" {{ !$b->is_active ? 'selected':'' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update Pembimbing</button>
      </div>
    </form>
  </div>
</div>
@endforeach
