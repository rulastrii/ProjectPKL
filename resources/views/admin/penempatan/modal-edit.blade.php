@foreach($penempatan as $row)
<div class="modal modal-blur fade" id="modalEditPenempatan-{{ $row->id }}" tabindex="-1">
 <div class="modal-dialog modal-dialog-centered modal-lg">

  <form action="{{ route('admin.penempatan.update',$row->id) }}"
        method="POST"
        class="modal-content">
   @csrf
   @method('PUT')

   {{-- HEADER --}}
   <div class="modal-header">
    <h5 class="modal-title">Edit Penempatan</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
   </div>

   {{-- BODY --}}
   <div class="modal-body">
    <div class="row g-3">

      <!-- Pengajuan / Siswa -->
      <div class="col-12 col-md-6">
        <label class="form-label">Pengajuan (Siswa)</label>
        <select name="pengajuan_id" class="form-select" required>
          <option value="">-- Select Siswa --</option>
          @foreach($pengajuan as $p)
            <option value="{{ $p->id }}"
              {{ $p->id == $row->pengajuan_id ? 'selected' : '' }}>
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
            <option value="{{ $b->id }}"
              {{ $b->id == $row->bidang_id ? 'selected' : '' }}>
              {{ $b->nama }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Status -->
      <div class="col-12 col-md-6">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
          <option value="1" {{ $row->is_active ? 'selected' : '' }}>Active</option>
          <option value="0" {{ !$row->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

    </div>
   </div>

   {{-- FOOTER --}}
   <div class="modal-footer">
    <button type="reset" class="btn btn-secondary">Reset</button>
    <button type="submit" class="btn btn-primary ms-auto">
      Update
    </button>
   </div>

  </form>

 </div>
</div>
@endforeach
