@foreach($pembimbing as $b)
@php
    $currentKey =
        $b->pengajuan_type === \App\Models\PengajuanPklmagang::class
        ? 'pkl:'.$b->pengajuan_id
        : 'mhs:'.$b->pengajuan_id;
@endphp

<!-- Modal Edit Pembimbing -->
<div class="modal modal-blur fade" id="modalEditPembimbing-{{ $b->id }}" tabindex="-1">
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

          {{-- PENGAJUAN --}}
          <div class="col-12">
            <label class="form-label required">Pengajuan</label>
            <select name="pengajuan_key" class="form-select" required>
              <option value="">-- Pilih Pengajuan --</option>

              <optgroup label="PKL / Magang Siswa">
                @foreach($pkl as $p)
                  <option value="pkl:{{ $p->id }}"
                    {{ $currentKey === 'pkl:'.$p->id ? 'selected' : '' }}>
                    [PKL] {{ $p->no_surat }} - {{ $p->sekolah->nama ?? '-' }}
                  </option>
                @endforeach
              </optgroup>

              <optgroup label="Magang Mahasiswa">
                @foreach($mahasiswa as $m)
                  <option value="mhs:{{ $m->id }}"
                    {{ $currentKey === 'mhs:'.$m->id ? 'selected' : '' }}>
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
              @foreach($pegawai as $peg)
                <option value="{{ $peg->id }}"
                  {{ $b->pegawai_id == $peg->id ? 'selected' : '' }}>
                  {{ $peg->nama }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- TAHUN --}}
          <div class="col-12 col-md-6">
            <label class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control"
                   value="{{ $b->tahun }}">
          </div>

          {{-- STATUS --}}
          <div class="col-12 col-md-6">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" {{ $b->is_active ? 'selected' : '' }}>Active</option>
              <option value="0" {{ !$b->is_active ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary ms-auto">
          <i class="ti ti-check me-1"></i> Update Pembimbing
        </button>
      </div>

    </form>
  </div>
</div>
@endforeach
