@extends('layouts.app')
@section('title','Detail Pusat Bantuan')
@section('content')

<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">

    {{-- Header --}}
    <div class="card mb-3">
     <div class="card-header">
      <h3 class="card-title"> Detail Permintaan Bantuan</h3>
     </div>

     <div class="card-body">
      <div class="row mb-2">
        <div class="col-md-6">
            <strong>Nama</strong>
            <div class="text-secondary">{{ $help->name }}</div>
        </div>
        <div class="col-md-6">
            <strong>Email</strong>
            <div class="text-secondary">{{ $help->email }}</div>
        </div>
      </div>

      <div class="mb-3">
        <strong>Alasan</strong>
        <div class="border rounded p-3 bg-light mt-1">
            {{ $help->reason }}
        </div>
      </div>

      <div>
        <strong>Status</strong><br>
        <span class="badge text-{{
            $help->status == 'pending' ? 'warning' :
            ($help->status == 'approved' ? 'success' : 'danger')
        }}">
            {{ strtoupper($help->status) }}
        </span>
      </div>
     </div>
    </div>

    {{-- Action --}}
    <div class="card">
     <div class="card-body d-flex gap-2">

      @if($help->user && !$help->user->is_active && $help->status == 'pending')
        <form action="{{ route('admin.help.unblock', $help->id) }}"
              method="POST"
               class="form-unblock">
            @csrf
            <button type="button" class="btn btn-success btn-unblock">
                <i class="ti ti-user-check me-1"></i>
                 Buka Akun & Selesaikan
            </button>
        </form>
      @else
        <div class="alert alert-info mb-0">
            Permintaan sudah diproses atau akun aktif.
        </div>
      @endif

      <a href="{{ route('admin.help.index') }}" class="btn btn-outline-secondary ms-auto">
        ← Kembali
      </a>

     </div>
    </div>

   </div>
  </div>
 </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-unblock').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Konfirmasi',
                text: 'Yakin ingin menyelesaikan permintaan ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, proses',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#198754', // bootstrap success
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection

