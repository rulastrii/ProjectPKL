@extends('layouts.app')

@section('title', 'Submit Tugas')

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10 col-12">

                <div class="card border-0 shadow-lg rounded-3">

                    {{-- HEADER --}}
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="ti ti-send me-2"></i> Submit Tugas
                        </h5>
                        <span class="badge bg-warning text-white">
                            <i class="ti ti-clock me-1"></i>
                            {{ $tugas->tenggat_formatted }}
                        </span>
                    </div>

                    {{-- BODY --}}
                    <div class="card-body">

                        {{-- ERROR --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- INFO TUGAS --}}
                        <div class="mb-4">
                            <label class="form-label text-muted">Judul Tugas</label>
                            <div class="fw-bold fs-5">{{ $tugas->judul }}</div>
                        </div>

                        <form action="{{ route('magang.tugas.submit', $tugas->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf

                            {{-- CATATAN --}}
                            <div class="mb-3">
                                <label class="form-label">Catatan / Keterangan</label>
                                <textarea name="catatan"
                                          rows="4"
                                          class="form-control">{{ old('catatan', $submit->catatan ?? '') }}</textarea>
                            </div>

                            {{-- FILE --}}
                            <div class="mb-3">
                                <label class="form-label">Upload File</label>

                                @if(!empty($submit?->file))
                                    <div class="mb-2">
                                        <a href="{{ asset($submit->file) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye"></i> Lihat File Sebelumnya
                                        </a>
                                    </div>
                                @endif

                                <input type="file"
                                       name="file"
                                       id="fileInput"
                                       accept="application/pdf"
                                       class="form-control">

                                <small class="text-muted">
                                    Upload ulang hanya jika ingin mengganti file
                                </small>

                                <div id="filePreview" class="mt-3 d-none">
                                    <a href="#" id="pdfLink" target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-eye me-1"></i> Preview PDF
                                    </a>
                                </div>
                            </div>

                            {{-- LINK --}}
                            <div class="mb-3">
                                <label class="form-label">Link Lampiran</label>
                                <input type="url"
                                       name="link_lampiran"
                                       value="{{ old('link_lampiran', $submit->link_lampiran ?? '') }}"
                                       class="form-control"
                                       placeholder="https://drive.google.com/...">
                            </div>

                            {{-- FOOTER --}}
                            <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-4">
                                <a href="{{ route('magang.tugas.index') }}" class="btn btn-secondary">
                                    Batal
                                </a>

                                <button type="submit" class="btn btn-success">
                                    <i class="ti ti-send me-1"></i>
                                    {{ isset($submit) ? 'Perbarui Tugas' : 'Kumpulkan Tugas' }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- PREVIEW PDF --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('fileInput');
    const preview = document.getElementById('filePreview');
    const link = document.getElementById('pdfLink');

    if (!input) return;

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return preview.classList.add('d-none');

        if (file.type === 'application/pdf') {
            link.href = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            alert('Hanya file PDF');
            input.value = '';
            preview.classList.add('d-none');
        }
    });
});
</script>
@endsection
