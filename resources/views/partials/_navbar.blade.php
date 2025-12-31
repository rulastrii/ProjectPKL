<nav class="navbar navbar-expand-lg navbar-light px-5 px-lg-5 py-3 py-lg-0">
    <a href="{{ route('welcome') }}" 
   class="navbar-brand p-0 d-flex align-items-center">
    <img src="{{ asset('img/logo-dkis.png') }}" 
         alt="Logo DKIS" 
         class="logo-dkis">
</a>


    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="fa fa-bars"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto py-0 align-items-center">

            <a href="{{ route('welcome') }}" class="nav-item nav-link active">Home</a>
            <a href="#syarat-magang" class="nav-item nav-link">Syarat Magang</a>
            <a href="#dokumentasi" class="nav-item nav-link">Dokumentasi</a>
            <a href="#about" class="nav-item nav-link">About</a>
            <a href="#faqs" class="nav-item nav-link">FAQs</a>

            <!-- SEARCH ICON -->
            <div class="nav-item position-relative ms-3">
                <button id="searchToggle" class="btn btn-light rounded-circle">
                    <i class="fas fa-search"></i>
                </button>

                <!-- SEARCH DROPDOWN -->
                <div id="searchBox" class="search-box shadow">
                    <input id="nav-search" type="text" class="form-control" placeholder="Cari informasi...">
                    <div id="nav-search-results"></div>
                </div>
            </div>

        </div>

        <a href="{{ route('login') }}" class="btn btn-info text-white rounded-pill ms-3">Masuk</a>
        <a href="{{ route('magang.daftar') }}" class="btn btn-primary text-white rounded-pill ms-2">Apply Magang</a>
    </div>
</nav>


<!-- Carousel Start -->
<div class="header-carousel owl-carousel">
    <div class="header-carousel-item">
        <img src="{{ asset('img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="container text-center">
                <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di SIPEMANG</h4>
                <h1 class="display-4 text-uppercase text-white mb-4">Aplikasi Administrasi dan Pembinaan Peserta Magang/PKL DKIS Kota Cirebon</h1>
                <p class="mb-5 fs-5">"Masa Depan Cerah Dimulai dari Sini!"</p>
            </div>
        </div>
    </div>

    <div class="header-carousel-item">
        <img src="{{ asset('img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="container text-center">
                <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di SIPEMANG</h4>
                <h1 class="display-4 text-uppercase text-white mb-4">Aplikasi Administrasi dan Pembinaan Peserta Magang/PKL DKIS Kota Cirebon</h1>
                <p class="mb-5 fs-5">"Masa Depan Cerah Dimulai dari Sini!"</p>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->

<!-- Script Search Navbar -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('searchToggle');
    const box = document.getElementById('searchBox');
    const input = document.getElementById('nav-search');
    const results = document.getElementById('nav-search-results');

    // Toggle buka/tutup
    toggle.addEventListener('click', () => {
        box.style.display = box.style.display === 'block' ? 'none' : 'block';
        input.focus();
    });

    // Klik luar nutup
    document.addEventListener('click', (e) => {
        if (!box.contains(e.target) && !toggle.contains(e.target)) {
            box.style.display = 'none';
        }
    });

    // AJAX search
    input.addEventListener('input', function () {
        const q = this.value.trim();
        if (q.length < 2) {
            results.innerHTML = '';
            return;
        }

        fetch(`{{ route('search') }}?q=${q}`)
            .then(res => res.json())
            .then(data => {
                if (!data.length) {
                    results.innerHTML = '<small class="text-muted">Tidak ada hasil</small>';
                    return;
                }

                results.innerHTML = data.map(item => `
                    <a href="${item.link}">
                        <strong>${item.title}</strong><br>
                        <small>${item.excerpt}</small>
                    </a>
                `).join('');
            });
    });
});
</script>

