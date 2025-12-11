<!-- Modal Show Pegawai -->
<div class="modal modal-blur fade" id="modalShowPegawai-{{ $pegawai->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="card">
          <div class="card-body">

            <div class="row g-4">

              <!-- LEFT -->
              <div class="col-md-6">
                <h3 class="mb-1">{{ $pegawai->nama }}</h3>

                <div class="text-body">NIP: 
                  <strong>{{ $pegawai->nip ?? '-' }}</strong>
                </div>

                <div class="mt-2">
                  <span class="badge bg-{{ $pegawai->is_active ? 'bg-success-soft text-success' : 'red' }}">
                    {{ $pegawai->is_active ? 'Aktif' : 'Tidak Aktif' }}
                  </span>
                </div>
              </div>

              <!-- RIGHT -->
              <div class="col-md-6 text-md-end">
                <div class="text-body">Dibuat:</div>
                <div>{{ $pegawai->created_date }}</div>
                
                <div class="text-body mt-2">Terakhir Update:</div>
                <div>{{ $pegawai->updated_date ?? '-' }}</div>
              </div>

              <div class="col-12">
                <div class="hr-text">Informasi Lengkap</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Jabatan</label>
                <div class="text-body">{{ $pegawai->jabatan ?? '-' }}</div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">Bidang</label>
                <div class="text-body">
                  {{ $pegawai->bidang->nama ?? '-' }}
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label fw-bold">User Login (Opsional)</label>
                <div class="text-body">
                  {{ $pegawai->user->name ?? '-' }}
                </div>
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
