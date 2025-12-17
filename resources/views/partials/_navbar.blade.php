<nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="{{ route('welcome') }}" class="navbar-brand p-0">
                    <!-- <h1 class="text-primary"><i class="fas fa-search-dollar me-3"></i>Stocker</h1>-->
                        <img id="logo-dark" src="{{ asset('img/logo-dark.png') }}" alt="Logo" style="height:45px; display:none;">
                        <img id="logo-light" src="{{ asset('img/logo-light.png') }}" alt="Logo" style="height:45px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="{{ route('welcome') }}" class="nav-item nav-link active">Home</a>
                        <a href="#" class="nav-item nav-link">Syarat Magang</a>
                        <a href="#" class="nav-item nav-link">Dokumentasi</a>
                        <a href="#" class="nav-item nav-link">About</a>
                        <a href="#" class="nav-item nav-link">Kontak</a>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-info text-white rounded-pill py-2 px-4 my-3 my-lg-0 me-2 flex-shrink-0">Masuk</a>
                    <a href="{{ route('magang.daftar') }}" class="btn btn-primary text-white rounded-pill py-2 px-4 my-3 my-lg-0 flex-shrink-0">Apply Magang</a>
                </div>
            </nav>

            <!-- Carousel Start -->
            <div class="header-carousel owl-carousel">
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-1.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row g-5">
                                <div class="col-12 animated fadeInUp">
                                    <div class="text-center">
                                        <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di SIPEMANG</h4>
                                        <h1 class="display-4 text-uppercase text-white mb-4">Aplikasi Administrasi dan Pembinaan Peserta Magang/PKL DKIS Kota Cirebon</h1>
                                        <p class="mb-5 fs-5">"Masa Depan Cerah Dimulai dari Sini!"</p>

                                        <div class="d-flex justify-content-center flex-shrink-0 mb-4">
                                            <div class="position-relative" style="width: 300px;">
                                                <input type="text" class="form-control rounded-pill ps-5" placeholder="Cari informasi...">
                                                <i class="fas fa-search position-absolute" 
                                                style="top: 50%; left: 15px; transform: translateY(-50%); color: #888;"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header-carousel-item">
                    <img src="{{ asset('img/carousel-2.jpg') }}" class="img-fluid w-100" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row g-5">
                                <div class="col-12 animated fadeInUp">
                                    <div class="text-center">
                                        <h4 class="text-primary text-uppercase fw-bold mb-4">Selamat Datang di SIPEMANG</h4>
                                        <h1 class="display-4 text-uppercase text-white mb-4">Aplikasi Administrasi dan Pembinaan Peserta Magang/PKL DKIS Kota Cirebon</h1>
                                        <p class="mb-5 fs-5">"Masa Depan Cerah Dimulai dari Sini!"</p>

                                        <div class="d-flex justify-content-center flex-shrink-0 mb-4">
                                            <div class="position-relative" style="width: 300px;">
                                                <input type="text" class="form-control rounded-pill ps-5" placeholder="Cari informasi...">
                                                <i class="fas fa-search position-absolute" 
                                                style="top: 50%; left: 15px; transform: translateY(-50%); color: #888;"></i>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Carousel End -->