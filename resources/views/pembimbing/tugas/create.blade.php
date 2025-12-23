<form action="{{ route('pembimbing.tugas.store') }}" method="POST" id="tugasForm">
    @csrf

    {{-- Judul --}}
    <div class="mb-3">
        <label class="form-label fw-semibold small">Judul</label>
        <input type="text" name="judul" class="form-control form-control-sm border-primary" placeholder="Judul tugas..." required>
    </div>

    {{-- Deskripsi --}}
    <div class="mb-3">
        <label class="form-label fw-semibold small">Deskripsi</label>

        {{-- Toolbar --}}
        <div id="toolbar">
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

        {{-- Editor --}}
        <div id="editor" class="border border-primary rounded p-2" style="height:250px; background:#fff;"></div>
        <input type="hidden" name="deskripsi" id="hidden-deskripsi">
    </div>

    {{-- Tenggat --}}
    <div class="mb-3">
        <label class="form-label fw-semibold small">Tenggat</label>
        <input type="datetime-local" name="tenggat" class="form-control form-control-sm border-primary" required>
    </div>

    <div class="text-end mt-2">
        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
    </div>
</form>

{{-- Quill CSS & JS --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    // Image handler
    function imageHandler(quill) {
        let input = document.createElement('input');
        input.setAttribute('type','file');
        input.setAttribute('accept','image/*');
        input.click();
        input.onchange = () => {
            let file = input.files[0];
            if(/^image\//.test(file.type)){
                let reader = new FileReader();
                reader.onload = e => {
                    let range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', e.target.result);
                    quill.setSelection(range.index + 1);
                }
                reader.readAsDataURL(file);
            } else { alert('Hanya file gambar yang didukung.'); }
        }
    }

    // Video handler
    function videoHandler(quill) {
        let input = document.createElement('input');
        input.setAttribute('type','file');
        input.setAttribute('accept','video/*');
        input.click();
        input.onchange = () => {
            let file = input.files[0];
            if(/^video\//.test(file.type)){
                let reader = new FileReader();
                reader.onload = e => {
                    let range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'video', e.target.result);
                    quill.setSelection(range.index + 1);
                }
                reader.readAsDataURL(file);
            } else { alert('Hanya file video yang didukung.'); }
        }
    }

    // Inisialisasi Quill
    var quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Tulis deskripsi tugas di sini...',
        modules: {
            toolbar: {
                container: '#toolbar',
                handlers: {
                    'image': () => imageHandler(quill),
                    'video': () => videoHandler(quill)
                }
            }
        }
    });

    // Validasi sebelum submit
    document.getElementById('tugasForm').addEventListener('submit', function(e){
        let content = quill.root.innerHTML.trim();
        if(content === '' || content === '<p><br></p>'){
            alert('Deskripsi tidak boleh kosong!');
            e.preventDefault();
            return false;
        }
        document.getElementById('hidden-deskripsi').value = content;
    });
</script>
