@extends('layouts.landing')

@section('title', 'Landing Page')

@section('content')
<!-- Syarat Magang Start -->
        <div class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Syarat Magang</h4>
                    <h1 class="display-5 mb-4">Persiapkan diri Anda untuk magang di DKIS</h1>
                    <p class="mb-0">Berikut adalah beberapa syarat yang harus dipenuhi untuk mengikuti program magang di DKIS. Pastikan Anda memenuhi semua persyaratan sebelum mendaftar.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="feature-item p-4">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-envelope-open-text fa-4x text-primary"></i>
                            </div>
                            <h4>Surat Pengantar Kampus</h4>
                            <p class="mb-4">Surat pengantar dari kampus yang ditujukan kepada Kepala Kesbangpol sebagai persetujuan magang.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Detail</a>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="feature-item p-4">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-file-signature fa-4x text-primary"></i>
                            </div>
                            <h4>Surat Perizinan Kesbangpol</h4>
                            <p class="mb-4">Surat resmi dari Kesbangpol yang memberikan izin untuk melaksanakan magang di DKIS.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Detail</a>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="feature-item p-4">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-file-alt fa-4x text-primary"></i>
                            </div>
                            <h4>Proposal Magang</h4>
                            <p class="mb-4">Proposal magang yang menjelaskan tujuan, program, dan kegiatan yang akan dilakukan selama magang.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Detail</a>
                        </div>
                    </div>
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="0.8s">
                        <div class="feature-item p-4">
                            <div class="feature-icon p-4 mb-4">
                                <i class="fas fa-user fa-4x text-primary"></i>
                            </div>
                            <h4>CV Terbaru</h4>
                            <p class="mb-4">Curriculum Vitae terbaru yang memuat data pribadi, pendidikan, pengalaman, dan keahlian peserta.</p>
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="#">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Syarat Magang End -->

         <!-- Blog Start -->
        <div class="container-fluid blog pb-5">
            <div class="container pb-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Dokumentasi Kegiatan</h4>
                    <h1 class="display-5 mb-4">Kegiatan Magang/PKL Siswa</h1>
                    <p class="mb-0">Dokumentasi kegiatan Praktik Kerja Lapangan yang dilakukan siswa selama masa magang.
                        Kegiatan mencakup pembelajaran, praktik kerja, peyelesaian proyek, hingga penutupan program.
                    </p>
                </div>
                <div class="owl-carousel blog-carousel wow fadeInUp" data-wow-delay="0.2s">
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="img/service-1.jpg" class="img-fluid w-100 rounded" alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Hari Pertama</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Penerimaan & Perkenalan Tempat Magang</a>
                        <p class="mb-4"> Siswa diperkenalkan dengan lingkungan kerja serta pembagian tugas pada awal kegiatan PKL.</p>
                        <div class="d-flex align-items-center">
                            <img src="img/testimonial-1.jpg" class="img-fluid rounded-circle" style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Pembimbing</h5>
                                <p class="mb-0">October 9, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="img/service-2.jpg" class="img-fluid w-100 rounded" alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Aktivitas Kerja</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Pelaksanaan Tugas Harian</a>
                        <p class="mb-4">Dokumentasi kegiatan siswa saat praktik kerja, seperti input data, produksi, atau pekerjaan teknis.</p>
                        <div class="d-flex align-items-center">
                            <img src="img/testimonial-2.jpg" class="img-fluid rounded-circle" style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Pembimbing</h5>
                                <p class="mb-0">October 9, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="img/service-3.jpg" class="img-fluid w-100 rounded" alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Proyek</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Pengerjaan Proyek / Tugas</a>
                        <p class="mb-4"> Siswa mengerjakan proyek yang diberikan sebagai bagian dari pelatihan dan penilaian.</p>
                        <div class="d-flex align-items-center">
                            <img src="img/testimonial-3.jpg" class="img-fluid rounded-circle" style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Pembimbing</h5>
                                <p class="mb-0">October 9, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="blog-item p-4">
                        <div class="blog-img mb-4">
                            <img src="img/service-4.jpg" class="img-fluid w-100 rounded" alt="">
                            <div class="blog-title">
                                <a href="#" class="btn">Penutup</a>
                            </div>
                        </div>
                        <a href="#" class="h4 d-inline-block mb-3">Akhir Kegiatan & Dokumentasi Penutupan</a>
                        <p class="mb-4">Penyerahan sertifikat dan sesi dokumentasi sebagai tanda berakhirnya kegiatan magang/PKL.</p>
                        <div class="d-flex align-items-center">
                            <img src="img/testimonial-1.jpg" class="img-fluid rounded-circle" style="width: 60px; height: 60px;" alt="">
                            <div class="ms-3">
                                <h5>Pembimbing</h5>
                                <p class="mb-0">October 9, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Blog End -->

        <!-- Testimonial Start -->
<div class="container-fluid testimonial pb-5">
    <div class="container pb-5">
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
            <h4 class="text-primary">Testimonial</h4>
<h1 class="display-5 mb-4">Feedback Peserta Magang & PKL</h1>
<p class="mb-0">Berikut adalah pengalaman dan kesan siswa PKL serta mahasiswa magang setelah menyelesaikan program mereka di perusahaan kami.</p>
        </div>

        <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.2s">
            @foreach($feedbacks as $fb)
            <div class="testimonial-item">
                <div class="testimonial-quote-left">
                    <i class="fas fa-quote-left fa-2x"></i>
                </div>
                <div class="testimonial-img">
                    <img src="{{ $fb->foto ? asset('uploads/foto_siswa/'.$fb->foto) : asset('default-avatar.png') }}" 
                         class="img-fluid rounded-circle" alt="{{ $fb->nama_user }}">
                </div>
                <div class="testimonial-text">
                    <p class="mb-0">{{ $fb->feedback }}</p>
                </div>
                <div class="testimonial-title d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <h5 class="mb-0">{{ $fb->nama_user }}</h5>
                        <p class="mb-0">{{ ucfirst($fb->role_name) }}</p>
                    </div>
                    <div class="d-flex text-primary">
                        @for($i = 0; $i < $fb->bintang; $i++)
                            <i class="fas fa-star"></i>
                        @endfor
                        @for($i = $fb->bintang; $i < 5; $i++)
                            <i class="far fa-star"></i>
                        @endfor
                    </div>
                </div>
                <div class="testimonial-quote-right">
                    <i class="fas fa-quote-right fa-2x"></i>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Testimonial End -->


        <!-- Abvout Start -->
        <div class="container-fluid about pb-5">
            <div class="container pb-5">
                <div class="row g-5 align-items-center">
                    <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                        <div>
                            <h4 class="text-primary">About Us</h4>
                            <h1 class="display-5 mb-4">Meet our company unless miss the opportunity</h1>
                            <p class="mb-4">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Cum velit temporibus repudiandae ipsa, eaque perspiciatis cumque incidunt tenetur sequi reiciendis.
                            </p>
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex">
                                        <div><i class="fas fa-lightbulb fa-3x text-primary"></i></div>
                                        <div class="ms-4">
                                            <h4>Business Consuluting</h4>
                                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex">
                                        <div><i class="bi bi-bookmark-heart-fill fa-3x text-primary"></i></div>
                                        <div class="ms-4">
                                            <h4>Year Of Expertise</h4>
                                            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <a href="#" class="btn btn-primary rounded-pill py-3 px-5 flex-shrink-0">Discover Now</a>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex">
                                        <i class="fas fa-phone-alt fa-2x text-primary me-4"></i>
                                        <div>
                                            <h4>Call Us</h4>
                                            <p class="mb-0 fs-5" style="letter-spacing: 1px;">+01234567890</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded position-relative overflow-hidden">
                            <img src="img/about-2.png" class="img-fluid rounded w-100" alt="">
                            
                            <div class="" style="position: absolute; top: -15px; right: -15px;">
                                <img src="img/about-3.png" class="img-fluid" style="width: 150px; height: 150px; opacity: 0.7;" alt="">
                            </div>
                            <div class="" style="position: absolute; top: -20px; left: 10px; transform: rotate(90deg);">
                                <img src="img/about-4.png" class="img-fluid" style="width: 100px; height: 150px; opacity: 0.9;" alt="">
                            </div>
                            <div class="rounded-bottom">
                                <img src="img/about-5.jpg" class="img-fluid rounded-bottom w-100" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->
         
        <!-- FAQs Start -->
        <div class="container-fluid faq-section pb-5">
            <div class="container pb-5 overflow-hidden">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">FAQs</h4>
                    <h1 class="display-5 mb-4">Frequently Asked Questions</h1>
                    <p class="mb-0">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Tenetur adipisci facilis cupiditate recusandae aperiam temporibus corporis itaque quis facere, numquam, ad culpa deserunt sint dolorem autem obcaecati, ipsam mollitia hic.
                    </p>
                </div>
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="accordion accordion-flush bg-light rounded p-5" id="accordionFlushSection">
                            <div class="accordion-item rounded-top">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed rounded-top" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    What Does This Tool Do?
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                    What Are The Disadvantages Of Online Trading?
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                                    Is Online Trading Safe?
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFour">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                                    What Is Online Trading, And How Dose It Work?
                                    </button>
                                </h2>
                                <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingFive">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                                    Which App Is Best For Online Trading?
                                    </button>
                                </h2>
                                <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
                                </div>
                            </div>
                            <div class="accordion-item rounded-bottom">
                                <h2 class="accordion-header" id="flush-headingSix">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                                    How To Create A Trading Account?
                                    </button>
                                </h2>
                                <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded">
                            <img src="img/about-2.png" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQs End -->

@endsection