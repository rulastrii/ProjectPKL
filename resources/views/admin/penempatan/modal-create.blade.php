<div class="modal modal-blur fade" id="modalCreatePenempatan" tabindex="-1">
 <div class="modal-dialog modal-dialog-centered modal-lg">
  <form action="{{ route('admin.penempatan.store') }}" method="POST" class="modal-content">
   @csrf

   <div class="modal-header">
    <h5 class="modal-title">Add Penempatan</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
   </div>

   <div class="modal-body">
    <div class="row g-3">

      <!-- Pengajuan / Siswa -->
      <div class="col-12 col-md-6">
        <label class="form-label">Pengajuan (Siswa)</label>
        <select name="pengajuan_id" class="form-select" required>
            <option value="">-- Select Siswa --</option>
            @foreach($pengajuan as $p)
              <option value="{{ $p->id }}">
                {{ $p->siswaProfile->nama ?? 'Nama belum diisi' }}
                |
                {{ $p->siswaProfile->kelas ?? '-' }}
              </option>
            @endforeach
        </select>
      </div>

      <!-- Bidang -->
      <div class="col-12 col-md-6">
        <label class="form-label">Bidang</label>
        <select name="bidang_id" class="form-select" required>
            <option value="">-- Select Bidang --</option>
            @foreach($bidang as $b)
              <option value="{{ $b->id }}">{{ $b->nama }}</option>
            @endforeach
        </select>
      </div>

    </div>
   </div>

   <div class="modal-footer">
    <button type="reset" class="btn btn-secondary">Reset</button>
    <button type="submit" class="btn btn-primary ms-auto">Create</button>
   </div>
  </form>
 </div>
</div>
