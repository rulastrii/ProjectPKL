@foreach($tugas as $t)
<div class="modal fade" id="modalAssignTugas-{{ $t->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('pembimbing.tugas.assign', $t->id) }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-3">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="ti ti-user-check me-2"></i> Assign Tugas: {{ $t->judul }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <p class="text-muted mb-3">Pilih peserta yang akan ditugaskan ke tugas ini.</p>

                    <div class="mb-3">
                        <label for="siswaSelect-{{ $t->id }}" class="form-label">Peserta</label>
                        <select id="siswaSelect-{{ $t->id }}" name="siswa_id[]" multiple class="form-control" style="width:100%;">
                            <optgroup label="PKL">
                                @foreach($siswa->where('user.role_id', 4) as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Magang">
                                @foreach($siswa->where('user.role_id', '!=', 4) as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="modal-footer border-top">
                    <button type="submit" class="btn btn-success"><i class="ti ti-user-check me-1"></i> Assign</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>

            </div>
        </form>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function customMatcher(params, data) {
        // Jika tidak ada keyword, tampilkan semua
        if ($.trim(params.term) === '') return data;

        let term = params.term.toLowerCase();

        // Cek kategori PKL / Magang
        let parentLabel = $(data.element).parent('optgroup').attr('label').toLowerCase();
        if (parentLabel.indexOf(term) > -1) return data;

        // Cek nama siswa
        if (data.text.toLowerCase().indexOf(term) > -1) return data;

        // Tidak cocok
        return null;
    }

    $('#siswaSelect-{{ $t->id }}').select2({
        placeholder: "Pilih siswa...",
        width: '100%',
        closeOnSelect: false,
        allowClear: true,
        dropdownAutoWidth: true,
        matcher: customMatcher
    });
});
</script>
@endpush
@endforeach

<style>
/* Modal selalu di tengah vertikal */
.modal-dialog {
    position: relative;
    top: 50% !important;
    transform: translateY(-50%) !important;
    margin: 0 auto;
}

/* Select2 multiple height & padding */
.select2-container--default .select2-selection--multiple {
    min-height: 45px;
    padding: 5px;
}
</style>
