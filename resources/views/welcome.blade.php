@extends('layouts.landing')

@section('title', 'Landing Page')

@section('content')
        <!-- Syarat Magang Start -->
        <div id="syarat-magang" class="container-fluid feature py-5">
            <div class="container py-5">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">Syarat Magang</h4>
                    <h1 class="display-5 mb-4">Persiapkan diri Anda untuk magang di DKIS</h1>
                    <p class="mb-0">
                        Berikut adalah beberapa syarat yang harus dipenuhi untuk mengikuti program magang di DKIS.
                        Pastikan Anda memenuhi semua persyaratan sebelum mendaftar.
                    </p>
                </div>
                <div class="row g-4">
                    @foreach($syaratMagangItems as $index => $item)
                    <div class="col-md-6 wow fadeInUp" data-wow-delay="{{ 0.2 + ($index * 0.2) }}s">
                        <div class="feature-item p-4">
                            <div class="feature-icon p-4 mb-4">
                                <i class="{{ $item['icon'] }} fa-4x text-primary"></i>
                            </div>
                            <h4>{{ $item['title'] }}</h4>
                            <p class="mb-4">{!! nl2br(e($item['desc'])) !!}</p>
                            @if(isset($item['link']) && $item['link'] !== '#')
                            <a class="btn btn-primary rounded-pill py-2 px-4" href="{{ $item['link'] }}" target="_blank">
                                Detail
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        <!-- Syarat Magang End -->


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


        <!-- About Start -->
        <div id="about" class="container-fluid about pb-5">
            <div class="container pb-5">
                <div class="row g-5 align-items-center">
                    <!-- Text Left -->
                    <div class="col-xl-7 wow fadeInLeft" data-wow-delay="0.2s">
                        <div>
                            <h4 class="text-primary">{{ $aboutSection['subtitle'] ?? 'About Us' }}</h4>
                            <h1 class="display-5 mb-4">{{ $aboutSection['title'] ?? 'Sistem Informasi Pengajuan PKL & Magang DKIS Kota Cirebon' }}</h1>
                            <p class="mb-4">{{ $aboutSection['description'] ?? 'Sistem informasi ini memudahkan siswa/mahasiswa untuk mengajukan permohonan PKL dan magang secara online.' }}</p>

                            <div class="row g-4">
                                @foreach($aboutSection['features'] ?? [] as $feature)
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <div class="d-flex align-items-start p-3 rounded shadow-sm bg-white h-100">
                                        <div class="me-3">
                                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary text-white" style="width:60px; height:60px;">
                                                <i class="{{ $feature['icon'] }} fa-2x"></i>
                                            </span>
                                        </div>
                                        <div>
                                            <h5>{{ $feature['title'] }}</h5>
                                            <p class="mb-0">{{ $feature['desc'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Ornament / Icon Right -->
                    <div class="col-xl-5 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded d-flex justify-content-center align-items-center position-relative" style="height: 400px;">
                            <!-- Icon dekoratif besar di background -->
                            <i class="fas fa-building fa-6x text-white opacity-15 position-absolute"></i>

                            <!-- Beberapa ornamen tambahan -->
                            <div class="position-absolute top-0 start-50 translate-middle-x">
                                <i class="fas fa-cogs fa-2x text-white opacity-25"></i>
                            </div>
                            <div class="position-absolute bottom-0 end-0 me-4 mb-4">
                                <i class="fas fa-lightbulb fa-2x text-white opacity-25"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->

        <!-- FAQs Start -->
        <div id="faqs" class="container-fluid faq-section pb-5">
            <div class="container pb-5 overflow-hidden">
                <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                    <h4 class="text-primary">{{ $faqPage['subtitle'] ?? 'FAQs' }}</h4>
                    <h1 class="display-5 mb-4">{{ $faqPage['title'] ?? 'Frequently Asked Questions' }}</h1>
                    <p class="mb-0">{{ $faqPage['description'] ?? 'Berikut adalah pertanyaan yang sering diajukan.' }}</p>
                </div>

                <div class="row g-5 align-items-center">
                    <!-- Accordion Left -->
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.2s">
                        <div class="accordion accordion-flush bg-light rounded p-5" id="accordionFlushSection">
                            @foreach($faqItems ?? [] as $index => $faq)
                            <div class="accordion-item {{ $index === 0 ? 'rounded-top' : ($index === count($faqItems)-1 ? 'rounded-bottom' : '') }}">
                                <h2 class="accordion-header" id="flush-heading{{ $index }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $index }}" aria-expanded="false" aria-controls="flush-collapse{{ $index }}">
                                        Pertanyaan: {{ $faq['title'] ?? 'Pertanyaan' }}
                                    </button>
                                </h2>
                                <div id="flush-collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $index }}" data-bs-parent="#accordionFlushSection">
                                    <div class="accordion-body">Jawaban: {{ $faq['desc'] ?? 'Jawaban' }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Icon / Ornament Right -->
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <div class="bg-primary rounded d-flex justify-content-center align-items-center" style="height: 400px;">
                            <i class="fas fa-question-circle fa-6x text-white opacity-15"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- FAQs End -->

@endsection