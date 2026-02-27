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
           <!-- Input nama sekolah -->
    <input list="sekolah-list" id="sekolah-input" class="form-control" placeholder="Cari sekolah..." required>

    <!-- Hidden input untuk mengirim id sekolah ke backend -->
    <input type="hidden" name="sekolah_id" id="sekolah-id">

    <!-- Datalist sekolah -->
    <datalist id="sekolah-list">
        @foreach($sekolah as $s)
            <option data-id="{{ $s->id }}" value="{{ $s->nama }}"></option>
        @endforeach
    </datalist>

            {{-- Info jika sekolah tidak ditemukan --}}
            <small id="sekolah-not-found" class="text-danger d-none mt-1">Sekolah yang dicari tidak ada!</small>
            <button id="btn-tambah-sekolah" type="button" class="btn btn-sm btn-outline-primary mt-2 d-none" data-bs-toggle="modal" data-bs-target="#modalTambahSekolah">
                Tambah Sekolah Baru
            </button>

            <small class="text-muted d-block mt-1">
                Jika sekolah tidak ada, hubungi pusat bantuan.
            </small>
        </div>

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Periode Mulai</label>
            <input type="date" name="periode_mulai" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Periode Selesai</label>
            <input type="date" name="periode_selesai" class="form-control" required>
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

{{-- Modal Tambah Sekolah --}}
<div class="modal fade" id="modalTambahSekolah" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('guru.sekolah.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Sekolah Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">

          <div class="col-12 col-md-6">
    <label class="form-label">Nama Sekolah</label>
    <input type="text" name="nama" class="form-control" placeholder="Masukkan nama sekolah" value="{{ old('nama') }}" required>
    @error('nama')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


          <div class="col-12 col-md-6">
            <label class="form-label">NPSN</label>
            <input type="text" name="npsn" class="form-control" placeholder="Masukkan NPSN">
          </div>

          <div class="col-12">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" placeholder="Masukkan alamat sekolah"></textarea>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Kontak</label>
            <input type="text" name="kontak" class="form-control" placeholder="Masukkan kontak sekolah">
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select">
              <option value="1" selected>Aktif</option>
              <option value="0">Tidak Aktif</option>
            </select>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-primary ms-auto">Tambah Sekolah</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const sekolahInput = document.getElementById('sekolah-input');
    const datalist = document.getElementById('sekolah-list');
    const infoNotFound = document.getElementById('sekolah-not-found');
    const btnTambah = document.getElementById('btn-tambah-sekolah');
    const hiddenId = document.getElementById('sekolah-id');

    sekolahInput.addEventListener('input', function() {
        const term = this.value.toLowerCase().trim();
        const options = Array.from(datalist.options);

        let match = false;
        hiddenId.value = ''; // reset dulu

        options.forEach(opt => {
            if(opt.value.toLowerCase() === term) {
                match = true;
                hiddenId.value = opt.dataset.id; // set id sesuai nama
            }
        });

        if(term !== '' && !match) {
            infoNotFound.classList.remove('d-none');
            btnTambah.classList.remove('d-none'); // tampilkan tombol tambah
        } else {
            infoNotFound.classList.add('d-none');
            btnTambah.classList.add('d-none'); // sembunyikan tombol
        }
    });


    // Preview file PDF
    const fileInput = document.getElementById('file_surat');
    const linkContainer = document.getElementById('pdf-link-container');
    const link = document.getElementById('pdf-link');

    fileInput.addEventListener('change', function(e){
        const file = e.target.files[0];

        if(file && file.type === "application/pdf"){
            const url = URL.createObjectURL(file);
            link.href = url;
            linkContainer.style.display = 'block';
        } else {
            linkContainer.style.display = 'none';
            link.href = '#';
            if(file) alert('Silahkan pilih file PDF!');
        }
    });

});
</script>

@endsection
