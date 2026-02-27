<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="icon" type="image/png" href="{{ asset('img/logo-sipemang.png') }}">
    <title>Dashboard</title>
    <!-- CSS files -->
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('dist/css/tabler.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-flags.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-payments.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1692870487') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/demo.min.css?1692870487') }}" rel="stylesheet"/>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons@latest/iconfont/tabler-icons.min.css">

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body >
    <script src="{{ asset('dist/js/demo-theme.min.js?1692870487') }}"></script>
    <div class="page">
      <!-- Sidebar -->
        @include('partials.sidebar')

      <!-- Navbar -->
        @include('partials.header')

      <div class="page-wrapper">
        <!-- Page header -->
        
        @yield('content')
        <!-- Page body -->
        
        
        @include('partials.footer')
      </div>
    </div>
    <!-- Libs JS -->
    <script src="{{ asset('dist/libs/apexcharts/dist/apexcharts.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/libs/jsvectormap/dist/maps/world-merc.js?1692870487') }}" defer></script>
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js?1692870487') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js?1692870487') }}" defer></script>
    
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Set tahun otomatis
    document.getElementById('year').textContent = new Date().getFullYear();
</script>
<script>
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: true
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        showConfirmButton: true
    });
@endif

@if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'Warning!',
        text: @json(session('warning')),
        showConfirmButton: true
    });
@endif

@if(session('info'))
    Swal.fire({
        icon: 'info',
        title: 'Info!',
        text: @json(session('info')),
        showConfirmButton: true
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Kesalahan!',
        text: @json($errors->first()),
        showConfirmButton: true
    });
@endif
</script>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                Apakah Anda yakin ingin logout?
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  </body>
</html>