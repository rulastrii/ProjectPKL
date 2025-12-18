<!-- Modal Create Pembimbing -->
<!-- Modal Create Pembimbing -->
<div class="modal modal-blur fade" id="modalCreatePembimbing" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">

    <form action="{{ route('admin.pembimbing.store') }}" method="POST" class="modal-content">
      @csrf

      <div class="modal-header">
        <h5 class="modal-title">Add New Pembimbing</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          {{-- PENGAJUAN (PKL + MAHASISWA) --}}
          <div class="col-12">
            <label class="form-label required">Pengajuan</label>
            <select name="pengajuan_key" class="form-select" required>
              <option value="">-- Pilih Pengajuan --</option>

              <optgroup label="PKL / Magang Siswa">
                @foreach($pkl as $p)
                  <option value="pkl:{{ $p->id }}">
                    [PKL] {{ $p->no_surat }} - {{ $p->sekolah->nama ?? '-' }}
                  </option>
                @endforeach
              </optgroup>

              <optgroup label="Magang Mahasiswa">
                @foreach($mahasiswa as $m)
                  <option value="mhs:{{ $m->id }}">
                    [MHS] {{ $m->no_surat }} - {{ $m->nama_mahasiswa }}
                  </option>
                @endforeach
              </optgroup>
            </select>
          </div>

          {{-- PEGAWAI --}}
          <div class="col-12 col-md-6">
            <label class="form-label required">Pembimbing</label>
            <select name="pegawai_id" class="form-select" required>
              <option value="">-- Select Pegawai --</option>
              @foreach($pegawai as $peg)
                <option value="{{ $peg->id }}">{{ $peg->nama }}</option>
              @endforeach
            </select>
          </div>

          {{-- TAHUN --}}
          <div class="col-12 col-md-6">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" placeholder="Contoh: 2025">
          </div>

          {{-- STATUS --}}
          <div class="col-12 col-md-6">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" selected>Active</option>
              <option value="0">Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary ms-auto">
          <i class="ti ti-check me-1"></i> Create Pembimbing
        </button>
      </div>

    </form>
  </div>
</div>


{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('pengajuan_type');
    const pklWrap = document.getElementById('pengajuan_pkl_wrapper');
    const mhsWrap = document.getElementById('pengajuan_mahasiswa_wrapper');

    typeSelect.addEventListener('change', function () {
        pklWrap.classList.add('d-none');
        mhsWrap.classList.add('d-none');

        if (this.value === '{{ \App\Models\PengajuanPklmagang::class }}') {
            pklWrap.classList.remove('d-none');
        } else if (this.value === '{{ \App\Models\PengajuanMagangMahasiswa::class }}') {
            mhsWrap.classList.remove('d-none');
        }
    });
});
</script>
