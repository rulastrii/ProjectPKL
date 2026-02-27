@foreach($submits as $submit)
<div class="modal fade" id="gradeModal-{{ $submit->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pembimbing.tugas.grade', $submit->id) }}" method="POST">
            @csrf
            <div class="modal-content">

                {{-- Header --}}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        Nilai Submit - {{ $submit->siswa->nama }}
                        @if($submit->is_late)
                            <span class="badge bg-danger ms-2">Terlambat</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                {{-- Body --}}
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Skor</label>
                        <input type="number"
                               name="skor"
                               class="form-control"
                               value="{{ old('skor', $submit->skor) }}"
                               min="0" max="100" placeholder="Masukkan skor (0-100)"
                               required>
                    </div>

                    <div class="mb-3">
                        <label>Feedback</label>
                        <textarea name="feedback"
                                  class="form-control"
                                  placeholder="Masukkan feedback (opsional)">{{ old('feedback', $submit->feedback) }}</textarea>
                    </div>
@if($submit->is_late)
    <div class="alert alert-warning small mb-0">
        ⚠ <strong>Terlambat</strong>
        {{ $submit->late_days }} hari

        @if($submit->late_penalty > 0)
            | Penalti {{ $submit->late_penalty }}%
        @else
            | Tidak ada penalti nilai
        @endif
    </div>
@endif

                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Simpan Nilai
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>
@endforeach
