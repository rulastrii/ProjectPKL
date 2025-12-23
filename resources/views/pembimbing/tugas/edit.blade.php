@foreach($tugas as $t)
<!-- Modal Edit Tugas -->
<div class="modal fade" id="modalEditTugas-{{ $t->id }}" tabindex="-1" aria-labelledby="modalEditTugasLabel-{{ $t->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('pembimbing.tugas.update', $t->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Header Biru -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Edit Tugas: {{ $t->judul }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Judul --}}
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Judul</label>
                        <input type="text"
                               name="judul"
                               class="form-control form-control-sm"
                               value="{{ $t->judul }}"
                               required>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Deskripsi</label>

                        <div id="toolbar-{{ $t->id }}">
                            <span class="ql-formats">
                                <button class="ql-bold"></button>
                                <button class="ql-italic"></button>
                                <button class="ql-underline"></button>
                                <button class="ql-strike"></button>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-size"></select>
                                <select class="ql-color"></select>
                                <select class="ql-background"></select>
                            </span>
                            <span class="ql-formats">
                                <select class="ql-align"></select>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-list" value="ordered"></button>
                                <button class="ql-list" value="bullet"></button>
                                <button class="ql-indent" value="-1"></button>
                                <button class="ql-indent" value="+1"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-link"></button>
                                <button class="ql-image"></button>
                                <button class="ql-video"></button>
                            </span>
                            <span class="ql-formats">
                                <button class="ql-clean"></button>
                            </span>
                        </div>

                        <div id="editor-{{ $t->id }}" style="height:250px; background:#fff; border:1px solid #ced4da;"></div>
                        <input type="hidden" name="deskripsi" id="hidden-deskripsi-{{ $t->id }}" value="{{ $t->deskripsi }}">
                    </div>

                    {{-- Tenggat --}}
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Tenggat</label>
                        <input type="datetime-local"
                               name="tenggat"
                               class="form-control form-control-sm"
                               value="{{ \Carbon\Carbon::parse($t->tenggat)->format('Y-m-d\TH:i') }}"
                               required>
                    </div>

                    {{-- Status --}}
                    <div class="mb-2">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select form-select-sm">
                            <option value="pending" {{ $t->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="sudah dinilai" {{ $t->status == 'sudah dinilai' ? 'selected' : '' }}>Sudah Dinilai</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Quill JS per modal --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var quill_{{ $t->id }} = new Quill('#editor-{{ $t->id }}', {
        theme: 'snow',
        modules: {
            toolbar: {
                container: '#toolbar-{{ $t->id }}',
                handlers: {
                    image: function() {
                        var input = document.createElement('input');
                        input.setAttribute('type','file');
                        input.setAttribute('accept','image/*');
                        input.click();
                        input.onchange = function() {
                            var file = input.files[0];
                            if (/^image\//.test(file.type)) {
                                var reader = new FileReader();
                                reader.onload = function(e){
                                    var range = quill_{{ $t->id }}.getSelection(true);
                                    quill_{{ $t->id }}.insertEmbed(range.index,'image',e.target.result);
                                    quill_{{ $t->id }}.setSelection(range.index+1);
                                };
                                reader.readAsDataURL(file);
                            } else { alert('Hanya file gambar yang didukung'); }
                        }
                    },
                    video: function() {
                        var input = document.createElement('input');
                        input.setAttribute('type','file');
                        input.setAttribute('accept','video/*');
                        input.click();
                        input.onchange = function() {
                            var file = input.files[0];
                            if (/^video\//.test(file.type)) {
                                var reader = new FileReader();
                                reader.onload = function(e){
                                    var range = quill_{{ $t->id }}.getSelection(true);
                                    quill_{{ $t->id }}.insertEmbed(range.index,'video',e.target.result);
                                    quill_{{ $t->id }}.setSelection(range.index+1);
                                };
                                reader.readAsDataURL(file);
                            } else { alert('Hanya file video yang didukung'); }
                        }
                    }
                }
            }
        }
    });

    // Set konten awal
    quill_{{ $t->id }}.root.innerHTML = document.querySelector('#hidden-deskripsi-{{ $t->id }}').value;

    // Submit form
    document.querySelector('#modalEditTugas-{{ $t->id }} form').onsubmit = function() {
        document.querySelector('#hidden-deskripsi-{{ $t->id }}').value = quill_{{ $t->id }}.root.innerHTML;
    };
});
</script>
@endforeach
