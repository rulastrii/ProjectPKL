@foreach($penempatan as $row)
<div class="modal modal-blur fade"
     id="modalEditPenempatan-{{ $row->id }}"
     tabindex="-1">
 <div class="modal-dialog modal-dialog-centered modal-lg">

  <form action="{{ route('admin.penempatan.update', $row->id) }}"
        method="POST"
        class="modal-content">
   @csrf
   @method('PUT')

   <div class="modal-header">
    <h5 class="modal-title">Edit Penempatan</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
   </div>

   <div class="modal-body">
    <div class="row g-3">

      {{-- Jenis Pengajuan --}}
      <div class="col-12 col-md-6">
        <label class="form-label">Jenis Pengajuan</label>
        <select class="form-select editJenisSelect"
                data-row="{{ $row->id }}">
          <option value="pkl"
            {{ $row->pengajuan_type === 'App\\Models\\PengajuanPklmagang' ? 'selected' : '' }}>
            PKL
          </option>
          <option value="mahasiswa"
            {{ $row->pengajuan_type === 'App\\Models\\PengajuanMagangMahasiswa' ? 'selected' : '' }}>
            Magang Mahasiswa
          </option>
        </select>
      </div>

      {{-- Pengajuan --}}
      <div class="col-12 col-md-6">
        <label class="form-label">Pengajuan</label>
        <select name="pengajuan_id"
                class="form-select editPengajuanSelect"
                id="editPengajuan-{{ $row->id }}"
                data-current="{{ $row->pengajuan_id }}"
                required>

          {{-- DEFAULT ISI DARI SERVER --}}
          @if($row->pengajuan_type === 'App\\Models\\PengajuanPklmagang')
            @foreach($pengajuanPkl as $p)
              <option value="{{ $p['id'] }}"
                {{ $p['id'] == $row->pengajuan_id ? 'selected' : '' }}>
                {{ $p['siswaProfile']['nama'] ?? '-' }} |
                {{ $p['siswaProfile']['kelas'] ?? '-' }}
              </option>
            @endforeach
          @else
            @foreach($pengajuanMahasiswa as $m)
              <option value="{{ $m['id'] }}"
                {{ $m['id'] == $row->pengajuan_id ? 'selected' : '' }}>
                {{ $m['nama_mahasiswa'] ?? '-' }} |
                {{ $m['email_mahasiswa'] ?? '-' }}
              </option>
            @endforeach
          @endif

        </select>
      </div>

      {{-- Hidden pengajuan_type --}}
      <input type="hidden"
             name="pengajuan_type"
             id="editType-{{ $row->id }}"
             value="{{ $row->pengajuan_type }}">

      {{-- Bidang --}}
      <div class="col-12 col-md-6">
        <label class="form-label">Bidang</label>
        <select name="bidang_id" class="form-select">
          @foreach($bidang as $b)
            <option value="{{ $b->id }}"
              {{ $b->id == $row->bidang_id ? 'selected' : '' }}>
              {{ $b->nama }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Status --}}
      <div class="col-12 col-md-6">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
          <option value="1" {{ $row->is_active ? 'selected' : '' }}>Active</option>
          <option value="0" {{ !$row->is_active ? 'selected' : '' }}>Inactive</option>
        </select>
      </div>

    </div>
   </div>

   <div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button class="btn btn-primary">Update</button>
   </div>

  </form>
 </div>
</div>
@endforeach


<script>
const pengajuanPKL = @json($pengajuanPkl);
const pengajuanMahasiswa = @json($pengajuanMahasiswa);

document.querySelectorAll('.editJenisSelect').forEach(select => {
  select.addEventListener('change', function () {

    const rowId = this.dataset.row;
    const jenis = this.value;

    const pengajuanSelect = document.getElementById('editPengajuan-' + rowId);
    const typeInput = document.getElementById('editType-' + rowId);

    // ✅ FIX INTI (INI DOANG)
    pengajuanSelect.innerHTML = '<option value="">-- Pilih Pengajuan --</option>';

    let html = '';

    if (jenis === 'pkl') {
      typeInput.value = 'App\\Models\\PengajuanPklmagang';

      pengajuanPKL.forEach(p => {
        html += `<option value="${p.id}">
          ${p.siswaProfile?.nama ?? '-'} | ${p.siswaProfile?.kelas ?? '-'}
        </option>`;
      });
    }

    if (jenis === 'mahasiswa') {
      typeInput.value = 'App\\Models\\PengajuanMagangMahasiswa';

      pengajuanMahasiswa.forEach(m => {
        html += `<option value="${m.id}">
          ${m.nama_mahasiswa ?? '-'} | ${m.email_mahasiswa ?? '-'}
        </option>`;
      });
    }

    pengajuanSelect.insertAdjacentHTML('beforeend', html);
  });
});
</script>

