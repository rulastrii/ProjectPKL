@extends('layouts.app')

@section('title','Form Pengajuan PKL/Magang')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row justify-content-center">
   <div class="col-md-8">
    <div class="card">
     <div class="card-header">
      <h3 class="card-title">Form Pengajuan PKL/Magang</h3>
     </div>
     <div class="card-body">
      <form action="{{ route('siswa.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Sekolah --}}
<div class="mb-3">
    <label class="form-label">Sekolah</label>
    <select id="sekolahSelect" name="sekolah_id" class="form-select @error('sekolah_id') is-invalid @enderror" required>
        <option value="">Cari nama sekolah...</option>
        @foreach($sekolah as $s)
            <option value="{{ $s->id }}" {{ old('sekolah_id') == $s->id ? 'selected' : '' }}>
                {{ $s->nama }}
            </option>
        @endforeach
    </select>
    @error('sekolah_id')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<!-- Tambahkan script di bawah -->
<script>
$(document).ready(function() {
    $('#sekolahSelect').select2({
        placeholder: "Cari nama sekolah...",
        allowClear: true,
        width: '100%'
    });
});
</script>


        {{-- Jumlah Siswa --}}
        <div class="mb-3">
            <label class="form-label">Jumlah Siswa</label>
            <input type="number" name="jumlah_siswa" class="form-control @error('jumlah_siswa') is-invalid @enderror" 
                   value="{{ old('jumlah_siswa') }}" min="1" placeholder="Masukkan jumlah siswa" required>
            @error('jumlah_siswa')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Periode Mulai --}}
        <div class="mb-3">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai" class="form-control @error('periode_mulai') is-invalid @enderror" 
                   value="{{ old('periode_mulai') }}" required>
            @error('periode_mulai')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Periode Selesai --}}
        <div class="mb-3">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai" class="form-control @error('periode_selesai') is-invalid @enderror" 
                   value="{{ old('periode_selesai') }}" required>
            @error('periode_selesai')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Upload File Surat --}}
        <div class="mb-3">
            <label class="form-label">Upload Surat (PDF)</label>
            <input type="file" name="file_surat" class="form-control @error('file_surat') is-invalid @enderror" accept="application/pdf" onchange="previewFile(event)">
            @error('file_surat')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Preview file --}}
            <div id="previewWrapper" class="mt-2" style="display:none;">
                <a id="previewLink" href="#" target="_blank" class="btn btn-sm btn-outline-primary">
                    Lihat File
                </a>
            </div>
        </div>

        {{-- Submit dan Kembali --}}
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('siswa.pengajuan.index') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-1"></i> Kembali
    </a>
    <button type="submit" class="btn btn-success">
        <i class="ti ti-plus me-1"></i> Ajukan PKL
    </button>
</div>


      </form>
     </div>
    </div>
   </div>
  </div>
 </div>
</div>

<script>
function previewFile(event){
    let file = event.target.files[0];
    if(file){
        let url = URL.createObjectURL(file);
        document.getElementById('previewLink').href = url;
        document.getElementById('previewWrapper').style.display = 'block';
    }
}
</script>
@endsection
