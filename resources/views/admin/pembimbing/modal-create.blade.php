<!-- Modal Create Pembimbing -->
<div class="modal modal-blur fade" id="modalCreatePembimbing" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <form action="{{ route('admin.pembimbing.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Pembimbing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <!-- Pengajuan -->
          <div class="col-12 col-md-6">
            <label class="form-label">Pengajuan</label>
            <select name="pengajuan_id" class="form-select" required>
              <option value="">-- Select Pengajuan --</option>
              @foreach($pengajuan as $p)
                <option value="{{ $p->id }}">{{ $p->no_surat }} - {{ $p->sekolah->nama ?? '-' }}</option>
              @endforeach
            </select>
          </div>

          <!-- Pegawai -->
          <div class="col-12 col-md-6">
            <label class="form-label">Pembimbing</label>
            <select name="pegawai_id" class="form-select" required>
              <option value="">-- Select Pegawai --</option>
              @foreach($pegawai as $peg)
                <option value="{{ $peg->id }}">{{ $peg->nama }}</option>
              @endforeach
            </select>
          </div>

          <!-- Tahun -->
          <div class="col-12 col-md-6">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" placeholder="Enter year" value="{{ old('tahun') }}">
          </div>

          <!-- Active -->
          <div class="col-12 col-md-6">
            <label class="form-label">Active</label>
            <select name="is_active" class="form-select">
              <option value="1" selected>Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Create Pembimbing</button>
      </div>
    </form>
  </div>
</div>
