@extends('layouts.app')

@section('title', 'Submit Tugas')

@section('content')
<div class="page-body">
    <div class="container-xl">

        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                {{-- Card dibuat seperti modal --}}
                <div class="card border-0 shadow-lg rounded-3">

                    {{-- Header (seperti modal-header) --}}
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-send me-2"></i>
                            Submit Tugas
                        </h5>

                        <span class="badge bg-warning text-white">
                            <i class="ti ti-clock me-1"></i>
                            {{ $tugas->tenggat_formatted ?? \Carbon\Carbon::parse($tugas->tenggat)->format('d M Y') }}
                        </span>
                    </div>

                    {{-- Body (seperti modal-body) --}}
                    <div class="card-body">

                        {{-- Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Info tugas --}}
                        <div class="mb-4">
                            <label class="form-label text-muted">Judul Tugas</label>
                            <div class="fw-bold fs-5">
                                {{ $tugas->judul }}
                            </div>
                        </div>

                        <form action="{{ route('magang.tugas.submit', $tugas->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            {{-- Catatan --}}
                            <div class="mb-3">
                                <label class="form-label">Catatan / Keterangan</label>
                                <textarea name="catatan"
                                          rows="4"
                                          class="form-control @error('catatan') is-invalid @enderror"
                                          placeholder="Tuliskan catatan tambahan (opsional)...">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- File --}}
                            <div class="mb-3">
                                <label class="form-label">Upload File (PDF)</label>
                                <input type="file"
                                       name="file"
                                       id="fileInput"
                                       required
                                       accept="application/pdf"
                                       class="form-control @error('file') is-invalid @enderror">

                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <small class="text-muted">
                                    Hanya file PDF yang bisa dipreview
                                </small>

                                {{-- Preview --}}
                                <div id="filePreview" class="mt-3 d-none">
                                    <a href="#"
                                       id="pdfLink"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i>
                                        Lihat PDF
                                    </a>
                                </div>
                            </div>

                            {{-- Link --}}
                            <div class="mb-3">
                                <label class="form-label">Link Lampiran</label>
                                <input type="url"
                                       name="link_lampiran"
                                       value="{{ old('link_lampiran') }}"
                                       class="form-control @error('link_lampiran') is-invalid @enderror"
                                       placeholder="https://drive.google.com/...">
                                @error('link_lampiran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Footer (seperti modal-footer) --}}
                            <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-4">
                                <a href="{{ route('magang.tugas.index') }}"
                                   class="btn btn-secondary">
                                    Batal
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-send me-1"></i>
                                    Submit
                                </button>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

{{-- SCRIPT (AMAN DI LAYOUT LARAVEL) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('fileInput');
    const preview = document.getElementById('filePreview');
    const link = document.getElementById('pdfLink');

    if (!input) return;

    input.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            preview.classList.add('d-none');
            return;
        }

        if (file.type === 'application/pdf') {
            link.href = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            alert('Hanya file PDF yang diperbolehkan');
            input.value = '';
            preview.classList.add('d-none');
        }
    });

});
</script>
@endsection
