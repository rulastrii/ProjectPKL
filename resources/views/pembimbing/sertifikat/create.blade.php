{{-- Modal Terbitkan Sertifikat --}}
<div class="modal modal-blur fade"
     id="modal-terbitkan-sertifikat"
     tabindex="-1"
     aria-hidden="true">

 <div class="modal-dialog modal-md modal-dialog-centered">
  <div class="modal-content shadow-lg border-0">

   {{-- Header --}}
   <div class="modal-header bg-primary">
    <h5 class="modal-title fw-bold text-white">
     Terbitkan Sertifikat
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
   </div>

   {{-- Form --}}
   <form action="{{ route('pembimbing.sertifikat.store') }}" method="POST">
    @csrf

    {{-- Body --}}
    <div class="modal-body">

     {{-- Peserta --}}
     <div class="mb-3">
      <label class="form-label fw-semibold">
        <i class="ti ti-user me-1"></i>
        Peserta
        <span class="text-danger">*</span>
      </label>

      <select name="siswa_id"
              class="form-select @error('siswa_id') is-invalid @enderror"
              required>
        <option value="">— Pilih Peserta —</option>
        @foreach($siswa as $item)
          <option value="{{ $item->id }}"
            {{ old('siswa_id') == $item->id ? 'selected' : '' }}>
            {{ $item->nama }}
          </option>
        @endforeach
      </select>

      <small class="text-muted">
        Hanya peserta yang telah memenuhi syarat & belum memiliki sertifikat
      </small>

      @error('siswa_id')
       <div class="invalid-feedback">
        {{ $message }}
       </div>
      @enderror
     </div>

     {{-- Judul Sertifikat --}}
     <div class="mb-3">
      <label class="form-label fw-semibold">
        <i class="ti ti-text-recognition me-1"></i>
        Judul Sertifikat
        <span class="text-muted">(opsional)</span>
      </label>

      <input type="text"
             name="judul"
             value="{{ old('judul') }}"
             class="form-control"
             placeholder="Sertifikat Penyelesaian Magang / PKL">

      <small class="text-muted">
        Jika dikosongkan, sistem akan menggunakan judul default
      </small>
     </div>

     {{-- Info --}}
     <div class="alert alert-info d-flex align-items-start mb-0">
      <i class="ti ti-info-circle me-2 fs-5"></i>
      <div>
       Sertifikat akan dibuat otomatis dalam format PDF dan
       memiliki <strong>QR Code validasi</strong>.
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
      <i class="ti ti-certificate me-1"></i> Terbitkan Sertifikat
     </button>
    </div>

   </form>

  </div>
 </div>
</div>
