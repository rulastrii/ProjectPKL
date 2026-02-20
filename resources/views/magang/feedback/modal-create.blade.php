<!-- Modal Create Feedback -->
<div class="modal fade" id="modalCreateFeedback" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('magang.feedback.store') }}" method="POST" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Feedback Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Feedback -->
          <div class="col-12">
            <label class="form-label">Feedback</label>
            <textarea name="feedback" class="form-control" rows="4" placeholder="Tulis feedback Anda..." required></textarea>
          </div>

          <!-- Bintang Klikable -->
          <div class="col-12 col-md-6">
            <label class="form-label">Bintang</label>
            <div class="star-rating d-flex gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <i class="ti ti-star text-muted star" data-value="{{ $i }}" style="cursor:pointer; font-size:1.5rem;"></i>
                @endfor
                <input type="hidden" name="bintang" value="0" required>
            </div>
          </div>

          <!-- Foto -->
          <input type="hidden" name="foto" value="{{ auth()->user()->foto ?? '' }}">

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Simpan Feedback</button>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('modalCreateFeedback');

    modalEl.addEventListener('shown.bs.modal', function () {
        const stars = modalEl.querySelectorAll('.star-rating .star');
        const input = modalEl.querySelector('input[name="bintang"]');

        function highlightStars(val) {
            stars.forEach(star => {
                if (parseInt(star.dataset.value) <= val) {
                    star.classList.add('text-warning');
                    star.classList.remove('text-muted');
                } else {
                    star.classList.add('text-muted');
                    star.classList.remove('text-warning');
                }
            });
        }

        // reset
        highlightStars(parseInt(input.value));

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                highlightStars(parseInt(this.dataset.value));
            });

            star.addEventListener('click', function() {
                input.value = this.dataset.value;
                highlightStars(parseInt(this.dataset.value));
            });

            star.addEventListener('mouseout', function() {
                highlightStars(parseInt(input.value));
            });
        });
    });
});
</script>
