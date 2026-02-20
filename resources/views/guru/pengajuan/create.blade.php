@extends('layouts.app')
@section('title','Buat Pengajuan PKL')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     {{-- Header --}}
     <div class="card-header">
      <h3 class="card-title">Buat Pengajuan PKL</h3>
     </div>

     {{-- Form --}}
     <div class="card-body">
      <form action="{{ route('guru.pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
          <label class="form-label">No Surat</label>
          <input type="text" name="no_surat" class="form-control" placeholder="Contoh: 123/PKL/2025" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Tanggal Surat</label>
          <input type="date" name="tgl_surat" class="form-control" placeholder="dd-mm-yyyy" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Sekolah</label>
          <select name="sekolah_id" class="form-select" required>
              <option value="">-- Pilih Sekolah --</option>
              @foreach($sekolah as $s)
                  <option value="{{ $s->id }}">{{ $s->nama }}</option>
              @endforeach
          </select>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai" class="form-control" placeholder="dd-mm-yyyy" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai" class="form-control" placeholder="dd-mm-yyyy" required>
          </div>
        </div>

        <div class="mb-3 mt-3">
          <label class="form-label">Email Guru</label>
          <input type="email" name="email_guru" class="form-control" placeholder="guru@example.com" required>
        </div>

        <div class="mb-3">
    <label class="form-label">Upload Surat</label>
    <input type="file" name="file_surat_path" id="file_surat" class="form-control" accept="application/pdf">
</div>

{{-- Tombol lihat PDF --}}
<div class="mb-3" id="pdf-link-container" style="display:none;">
    <a href="#" id="pdf-link" target="_blank" class="btn btn-outline-primary btn-sm">
        <i class="ti ti-file-text me-1"></i> Lihat PDF
    </a>
</div>



        <div class="mb-3">
          <label class="form-label">Catatan (opsional)</label>
          <textarea name="catatan" class="form-control" rows="3" placeholder="Contoh: Catatan tambahan jika ada"></textarea>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-success">
            <i class="ti ti-save me-1"></i> Simpan Draft
          </button>
          <a href="{{ route('guru.pengajuan.index') }}" class="btn btn-secondary ms-2">Kembali</a>
        </div>

      </form>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
<script>
document.getElementById('file_surat').addEventListener('change', function(e){
    const file = e.target.files[0];
    const linkContainer = document.getElementById('pdf-link-container');
    const link = document.getElementById('pdf-link');

    if(file && file.type === "application/pdf"){
        const url = URL.createObjectURL(file); // buat blob URL
        link.href = url; // set href link
        linkContainer.style.display = 'block';
    } else {
        linkContainer.style.display = 'none';
        link.href = '#';
        if(file) alert('Silahkan pilih file PDF!');
    }
});
</script>
@endsection
