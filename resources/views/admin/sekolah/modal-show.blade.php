<!-- Modal Show Sekolah -->
<div class="modal modal-blur fade" id="modalShowSekolah-{{ $sekolah->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Sekolah</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="card">
            <div class="card-body">

                <div class="row g-4">

                    <div class="col-md-6">
                        <h4 class="mb-1">{{ $sekolah->nama }}</h4>
                        <div class="text-body">NPSN: {{ $sekolah->npsn ?? '-' }}</div>
                        <div class="mt-2">
                            <span class="badge bg-{{ $sekolah->is_active ? 'bg-success-soft text-success' : 'red' }}">
                                {{ $sekolah->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 text-md-end">
                        <div class="text-body">Dibuat:</div>
                        <div>{{ $sekolah->created_date }}</div>
                        <div class="text-body mt-2">Terakhir Update:</div>
                        <div>{{ $sekolah->updated_date ?? '-' }}</div>
                    </div>

                    <div class="col-12">
                        <div class="hr-text">Informasi Lengkap</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Alamat</label>
                        <div class="text-body">{{ $sekolah->alamat }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Kontak</label>
                        <div class="text-body">{{ $sekolah->kontak ?? '-' }}</div>
                    </div>

                </div>

            </div>
        </div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Tutup
        </button>
      </div>

    </div>
  </div>
</div>
