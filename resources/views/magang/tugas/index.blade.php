@extends('layouts.app')
@section('title','Tugas Saya')

@section('content')
<div class="page-body">
 <div class="container-xl">
  <div class="row row-cards">
   <div class="col-12">
    <div class="card">

     <div class="card-header d-flex align-items-center">
      <h3 class="card-title">Tugas Saya</h3>
     </div>

     <div class="card-body border-bottom py-3">
      <form method="GET" class="d-flex w-100 gap-2">
        {{-- Show entries --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <span>Show</span>
            <select name="per_page"
                    class="form-select form-select-sm w-auto"
                    onchange="this.form.submit()">
                @foreach([5,10,25,50,100] as $size)
                    <option value="{{ $size }}" {{ request('per_page') == $size ? 'selected':'' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>
            <span>entries</span>
            {{-- Status --}}
            <select name="status"
                    class="form-select form-select-sm w-auto"
                    onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="sudah dinilai" {{ request('status')=='sudah dinilai' ? 'selected' : '' }}>
                    Sudah Dinilai
                </option>
            </select>
            {{-- Tenggat --}}
            <input type="date"
                  name="tenggat"
                  value="{{ request('tenggat') }}"
                  class="form-control form-control-sm w-auto"
                  onchange="this.form.submit()">
        </div>
        {{-- Search --}}
        <div class="ms-auto d-flex">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tugas..."
                 class="form-control form-control-sm">
          <button class="btn btn-sm btn-primary ms-2">Search</button>
        </div>
      </form>
     </div>

     <div class="table-responsive">
      <table class="table card-table table-vcenter text-nowrap">
       <thead>
        <tr>
         <th>No.</th>
         <th>Judul</th>
         <th>Tenggat</th>
         <th>Status</th>
         <th class="text-end">Aksi</th>
        </tr>
       </thead>

       <tbody>
        @forelse($tugas as $index => $t)
@php
    $submit = $t->submits->first();
@endphp

<tr>
    <td>{{ $tugas->firstItem() + $index }}</td>
    <td>{{ $t->judul }}</td>
    <td>{{ $t->tenggat_formatted }}</td>

    {{-- STATUS --}}
    <td>
    @if(!$submit)
        <span class="badge text-secondary">Belum submit</span>
    @elseif($submit->status === 'pending')
        <span class="badge text-warning">Sudah submit</span>
    @elseif($submit->status === 'sudah dinilai')
        <span class="badge text-success">Sudah dinilai</span>
    @endif
</td>


    {{-- AKSI --}}
    <td class="text-end">
        @if(!$submit)
            <a href="{{ route('magang.tugas.submitForm', $t->id) }}"
               class="btn btn-sm btn-outline-primary"
               title="Submit Tugas">
                <i class="ti ti-upload"></i>
            </a>

        @elseif($submit->status === 'pending')
            <a href="{{ route('magang.tugas.submitForm', $t->id) }}"
               class="btn btn-sm btn-outline-warning"
               title="Edit Submission">
                <i class="ti ti-edit"></i>
            </a>

        @elseif($submit->status === 'sudah dinilai')
            <a href="{{ route('magang.tugas.show', $t->id) }}"
               class="btn btn-sm btn-outline-success"
               title="Lihat Submission">
                <i class="ti ti-eye"></i>
            </a>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">Tidak ada tugas</td>
</tr>
@endforelse

       </tbody>
      </table>
     </div>

     {{-- Card Footer: Pagination --}}
     <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <strong>{{ $tugas->firstItem() }}</strong> to <strong>{{ $tugas->lastItem() }}</strong> of <strong>{{ $tugas->total() }}</strong> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <li class="page-item {{ $tugas->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $tugas->previousPageUrl() ?? '#' }}">prev</a>
            </li>

            @foreach ($tugas->getUrlRange(1, $tugas->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $tugas->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach

            <li class="page-item {{ $tugas->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $tugas->nextPageUrl() ?? '#' }}">next</a>
            </li>
        </ul>
     </div>

    </div>
   </div>
  </div>
 </div>
</div>
@endsection
