@foreach($penempatan as $row)
<div class="modal modal-blur fade" id="modalEditPenempatan-{{ $row->id }}" tabindex="-1">
 <div class="modal-dialog modal-dialog-centered modal-lg">
  <form action="{{ route('admin.penempatan.update', $row->id) }}" method="POST" class="modal-content">
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
        <input type="text" class="form-control" 
               value="{{ $row->pengajuan_type === 'App\\Models\\PengajuanPklSiswa' ? 'PKL' : 'Magang Mahasiswa' }}" 
               disabled>
      </div>

      {{-- Pengajuan --}}
      <div class="col-12 col-md-6">
        <label class="form-label">Pengajuan</label>
        <select name="pengajuan_id" class="form-select" required>
          @if($row->pengajuan_type === 'App\\Models\\PengajuanPklSiswa')
            @foreach($pengajuanPkl as $p)
              <option value="{{ $p['id'] }}" {{ $p['id'] == $row->pengajuan_id ? 'selected' : '' }}>
                {{ $p['nama'] ?? '-' }} | {{ $p['email'] ?? '-' }}
              </option>
            @endforeach
          @elseif($row->pengajuan_type === 'App\\Models\\PengajuanMagangMahasiswa')
            @foreach($pengajuanMahasiswa as $m)
              <option value="{{ $m['id'] }}" {{ $m['id'] == $row->pengajuan_id ? 'selected' : '' }}>
                {{ $m['nama_mahasiswa'] ?? '-' }} | {{ $m['email_mahasiswa'] ?? '-' }}
              </option>
            @endforeach
          @endif
        </select>
      </div>

      {{-- Hidden pengajuan_type --}}
      <input type="hidden" name="pengajuan_type" value="{{ $row->pengajuan_type }}">

      {{-- Bidang --}}
      <div class="col-12 col-md-6">
        <label class="form-label">Bidang</label>
        <select name="bidang_id" class="form-select">
          @foreach($bidang as $b)
            <option value="{{ $b->id }}" {{ $b->id == $row->bidang_id ? 'selected' : '' }}>{{ $b->nama }}</option>
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
