@extends('layouts.app')
@section('title','Feedback Saya')
@section('content')

<div class="page-body">
 <div class="container-xl">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Feedback Saya</h3>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCreateFeedback">
      <i class="ti ti-plus me-1"></i> Tambah Feedback
    </button>
  </div>

  {{-- Feedback Cards --}}
  <div class="row g-4">
  @forelse($feedbacks as $fb)
    <div class="col-12 col-sm-6 col-lg-4">
      <div class="card h-100 shadow-sm border-0 rounded-4 position-relative overflow-hidden"
           style="transition: transform 0.2s; {{ $fb->status === 'non-aktif' ? 'opacity:0.5;' : '' }}">
        <div class="card-body d-flex flex-column">

          {{-- Header: Foto, Nama, Role, Status --}}
          <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center">
              <img src="{{ $fb->foto ? asset('uploads/foto_siswa/'.$fb->foto) : asset('default-avatar.png') }}"
                   class="rounded-circle border border-2" width="50" height="50" alt="Avatar">
              <div class="ms-2">
                <h6 class="mb-0 fw-bold">{{ $fb->nama_user }}</h6>
                <small class="text-muted">{{ ucfirst($fb->role_name) }}</small>
              </div>
            </div>

            {{-- Toggle Status --}}
            <div class="form-check form-switch">
              <input class="form-check-input toggle-status" type="checkbox" data-id="{{ $fb->id }}" {{ $fb->status === 'aktif' ? 'checked' : '' }}>
              <label class="form-check-label">
                <span class="status-text">{{ $fb->status === 'aktif' ? 'Aktif' : 'Non-Aktif' }}</span>
              </label>
            </div>
          </div>

          {{-- Feedback Text --}}
          <p class="card-text flex-grow-1 text-truncate" style="max-height:5rem; overflow:hidden;">
            {{ $fb->feedback }}
          </p>

          {{-- Bintang --}}
          <div class="mb-2">
            @for($i=0; $i<$fb->bintang; $i++)
              <i class="ti ti-star text-warning fs-5"></i>
            @endfor
            @for($i=$fb->bintang; $i<5; $i++)
              <i class="ti ti-star text-muted fs-5"></i>
            @endfor
          </div>

          {{-- Tanggal --}}
          <small class="text-muted mb-3">Dibuat: {{ $fb->created_at->translatedFormat('d M Y, H:i') }}</small>

          {{-- Action --}}
          <div class="mt-auto d-flex justify-content-end">
            <button type="button" class="btn btn-outline-warning btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditFeedback-{{ $fb->id }}">
              <i class="ti ti-pencil"></i> Edit
            </button>
          </div>

        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="alert alert-info text-center">Belum ada feedback</div>
    </div>
  @endforelse
</div>


 </div>
</div>

@include('magang.feedback.modal-create')
@include('magang.feedback.modal-edit')

{{-- JS Toggle Status --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const toggles = document.querySelectorAll('.toggle-status');
  toggles.forEach(toggle => {
    const labelText = toggle.closest('.form-check').querySelector('.status-text');
    const card = toggle.closest('.card');

    toggle.addEventListener('change', function() {
      const feedbackId = this.dataset.id;
      const status = this.checked ? 'aktif' : 'non-aktif';

      // Update label
      labelText.innerText = status === 'aktif' ? 'Aktif' : 'Non-Aktif';

      // Update card opacity
      card.style.opacity = status === 'aktif' ? '1' : '0.5';

      // Send update to server
      fetch(`/magang/feedback/${feedbackId}/toggle-status`, {
        method: 'PUT',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: status })
      })
      .then(res => res.json())
      .then(data => {
        if(!data.success){
          alert('Gagal update status');
          // rollback UI jika gagal
          this.checked = !this.checked;
          labelText.innerText = this.checked ? 'Aktif' : 'Non-Aktif';
          card.style.opacity = this.checked ? '1' : '0.5';
        }
      });
    });
  });
});
</script>
@endpush

@endsection
