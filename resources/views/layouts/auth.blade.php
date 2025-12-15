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
    <title>Sign in</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1692870487" rel="stylesheet"/>
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
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
  <a href="{{ url('/login') }}" class="navbar-brand navbar-brand-autodark">
    <img src="{{ asset('img/logo-sipemang.png') }}" alt="SIPEMANG DKIS" class="navbar-brand-image" style="height:125px; width:auto;">
  </a>
</div>


        @yield('content')
        
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1692870487" defer></script>
    <script src="./dist/js/demo.min.js?1692870487" defer></script>
    <script>
// Toggle Password
document.getElementById('togglePassword').addEventListener('click', function () {
    const input = document.getElementById('password');
    const eye = document.getElementById('icon-eye');
    const eyeOff = document.getElementById('icon-eye-off');

    if (input.type === "password") {
        input.type = "text";
        eye.style.display = "none";
        eyeOff.style.display = "block";
    } else {
        input.type = "password";
        eye.style.display = "block";
        eyeOff.style.display = "none";
    }
});

// Toggle Confirm Password
document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
    const input = document.getElementById('password_confirmation');
    const eye = document.getElementById('confirm-eye');
    const eyeOff = document.getElementById('confirm-eye-off');

    if (input.type === "password") {
        input.type = "text";
        eye.style.display = "none";
        eyeOff.style.display = "block";
    } else {
        input.type = "password";
        eye.style.display = "block";
        eyeOff.style.display = "none";
    }
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('error'))
Swal.fire({
    icon: 'error',
    title: 'Gagal!',
    text: @json(session('error')),
});
@endif

@if($errors->any())
Swal.fire({
    icon: 'warning',
    title: 'Periksa input!',
    text: @json($errors->first()),
});
@endif

@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2000,
    showConfirmButton: true
});
@endif
</script>


  </body>
</html>