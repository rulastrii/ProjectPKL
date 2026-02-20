@foreach($feedbacks as $fb)
<!-- Modal Edit Feedback -->
<div class="modal fade" id="modalEditFeedback-{{ $fb->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form action="{{ route('magang.feedback.update', $fb->id) }}" method="POST" class="modal-content">
      @csrf
      @method('PUT')
      <div class="modal-header">
        <h5 class="modal-title">Edit Feedback: {{ $fb->nama_user }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">

          <!-- Feedback -->
          <div class="col-12">
            <label class="form-label">Feedback</label>
            <textarea name="feedback" class="form-control" rows="4" required>{{ $fb->feedback }}</textarea>
          </div>

          <!-- Bintang Klikable -->
          <div class="col-12 col-md-6">
            <label class="form-label">Bintang</label>
            <div class="star-rating d-flex gap-1">
                @for($i = 1; $i <= 5; $i++)
                    <i class="ti ti-star text-muted star" data-value="{{ $i }}" style="cursor:pointer; font-size:1.5rem;"></i>
                @endfor
                <input type="hidden" name="bintang" value="{{ $fb->bintang }}" required>
            </div>
          </div>

          <!-- Foto (hidden, tetap ambil dari user login) -->
          <input type="hidden" name="foto" value="{{ auth()->user()->foto ?? '' }}">

        </div>
      </div>

      <div class="modal-footer">
        <button type="reset" class="btn btn-secondary">Reset</button>
        <button type="submit" class="btn btn-outline-primary ms-auto">Update Feedback</button>
      </div>

    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalEditFeedback-{{ $fb->id }}');
    modal.addEventListener('shown.bs.modal', function () {
        const stars = modal.querySelectorAll('.star-rating .star');
        const input = modal.querySelector('input[name="bintang"]');

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

        // reset bintang sesuai nilai awal
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
@endforeach
