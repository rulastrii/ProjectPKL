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

      <!-- Jenis Pengajuan -->
      <div class="col-12 col-md-6">
        <label class="form-label">Jenis Pengajuan</label>
        <select name="jenis_pengajuan" class="form-select" id="jenisPengajuanSelect" required>
          <option value="">-- Pilih Jenis Pengajuan --</option>
          <option value="pkl">PKL</option>
          <option value="mahasiswa">Magang Mahasiswa</option>
        </select>
      </div>

      <!-- Pengajuan / Siswa atau Mahasiswa -->
      <div class="col-12 col-md-6">
        <label class="form-label">Pengajuan (Siswa/Mahasiswa)</label>
        <select name="pengajuan_id" class="form-select" id="pengajuanSelect" required>
          <option value="">-- Pilih Pengajuan --</option>
        </select>
      </div>

      <!-- Hidden input pengajuan_type -->
      <input type="hidden" name="pengajuan_type" id="pengajuanTypeInput">

      <!-- Bidang -->
      <div class="col-12 col-md-6">
        <label class="form-label">Bidang</label>
        <select name="bidang_id" class="form-select" required>
          <option value="">-- Pilih Bidang --</option>
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

<script>
const pengajuanPKL = @json($pengajuanPkl ?? []);
const pengajuanMahasiswa = @json($pengajuanMahasiswa ?? []);

const jenisSelect = document.getElementById('jenisPengajuanSelect');
const pengajuanSelect = document.getElementById('pengajuanSelect');
const pengajuanTypeInput = document.getElementById('pengajuanTypeInput');

function loadPengajuan(type) {
    let options = '<option value="">-- Pilih Pengajuan --</option>';

    if (type === 'pkl') {
        pengajuanTypeInput.value = 'App\\Models\\PengajuanPklSiswa';

        pengajuanPKL.forEach(p => {
            const nama  = p.nama ?? 'Nama belum diisi';
            const email = p.email ?? '-';
            options += `<option value="${p.id}">${nama} | ${email}</option>`;
        });

    } else if (type === 'mahasiswa') {
        pengajuanTypeInput.value = 'App\\Models\\PengajuanMagangMahasiswa';

        pengajuanMahasiswa.forEach(p => {
            const nama  = p.nama_mahasiswa ?? 'Nama belum diisi';
            const email = p.email_mahasiswa ?? '-';
            options += `<option value="${p.id}">${nama} | ${email}</option>`;
        });
    } else {
        pengajuanTypeInput.value = '';
    }

    pengajuanSelect.innerHTML = options;
}

// Reset modal
document.getElementById('modalCreatePenempatan')
    .addEventListener('show.bs.modal', function () {
        jenisSelect.value = '';
        pengajuanSelect.innerHTML = '<option value="">-- Pilih Pengajuan --</option>';
        pengajuanTypeInput.value = '';
    });

jenisSelect.addEventListener('change', function () {
    loadPengajuan(this.value);
});
</script>

