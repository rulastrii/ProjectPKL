<div class="modal modal-blur fade"
     id="modal-edit-penilaian-{{ $item->id }}"
     tabindex="-1"
     aria-hidden="true">

 <div class="modal-dialog modal-md modal-dialog-centered">
  <div class="modal-content shadow-lg border-0">

   {{-- Header --}}
   <div class="modal-header bg-primary">
    <h5 class="modal-title fw-bold text-white">
        Edit Nilai Akhir
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
   </div>

   <form action="{{ route('pembimbing.penilaian-akhir.update', $item->id) }}"
         method="POST">
    @csrf
    @method('PUT')

    {{-- Body --}}
    <div class="modal-body">

     {{-- Nama Siswa --}}
     <div class="mb-3">
      <label class="form-label fw-semibold">
        <i class="ti ti-user me-1"></i> Nama Peserta
      </label>
      <input type="text"
             class="form-control bg-light"
             value="{{ $item->siswa->nama }}"
             readonly>
     </div>

     <div class="row g-3">
      {{-- Nilai Keaktifan --}}
      <div class="col-md-6">
       <label class="form-label fw-semibold">
        <i class="ti ti-activity me-1"></i> Nilai Keaktifan
       </label>
       <input type="number"
              name="nilai_keaktifan"
              class="form-control"
              min="0" max="100"
              value="{{ old('nilai_keaktifan', $item->nilai_keaktifan) }}"
              required>
       <small class="text-muted">Rentang nilai 0 – 100</small>
      </div>

      {{-- Nilai Sikap --}}
      <div class="col-md-6">
       <label class="form-label fw-semibold">
        <i class="ti ti-mood-smile me-1"></i> Nilai Sikap
       </label>
       <input type="number"
              name="nilai_sikap"
              class="form-control"
              min="0" max="100"
              value="{{ old('nilai_sikap', $item->nilai_sikap) }}"
              required>
       <small class="text-muted">Rentang nilai 0 – 100</small>
      </div>
     </div>

     {{-- Info --}}
     <div class="alert alert-info d-flex align-items-center mt-4 mb-0">
      <i class="ti ti-info-circle me-2 fs-5"></i>
      <div>
        <strong>Catatan:</strong><br>
        Nilai akhir dihitung otomatis oleh sistem
      </div>
     </div>

    </div>

    {{-- Footer --}}
    <div class="modal-footer">
     <button type="button"
             class="btn btn-outline-secondary"
             data-bs-dismiss="modal">
      <i class="ti ti-x me-1"></i> Batal
     </button>

     <button type="submit" class="btn btn-primary">
      <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan
     </button>
    </div>

   </form>

  </div>
 </div>
</div>
