@foreach($submits as $submit)
    <div class="modal fade" id="gradeModal-{{ $submit->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('pembimbing.tugas.grade', $submit->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    {{-- Header --}}
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Nilai Submit - {{ $submit->siswa->nama }}</h5>
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
                                   min="0" max="100" 
                                   placeholder="Masukkan skor 0-100"
                                   title="Skor maksimal 100" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label>Feedback</label>
                            <textarea name="feedback" 
                                      class="form-control" 
                                      placeholder="Masukkan feedback untuk peserta" 
                                      title="Feedback opsional">{{ old('feedback', $submit->feedback) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control" title="Pilih status submit">
                                <option value="pending" {{ $submit->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sudah dinilai" {{ $submit->status == 'sudah dinilai' ? 'selected' : '' }}>Sudah Dinilai</option>
                            </select>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" title="Simpan nilai submit">Simpan Nilai</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Batal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
