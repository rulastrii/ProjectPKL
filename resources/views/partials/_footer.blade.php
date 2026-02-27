<!-- Footer Start -->
        <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.2s">
            <div class="container-fluid px-5 py-5" style="border-top: 1px solid rgba(255,255,255,0.1); border-bottom:1px solid rgba(255,255,255,0.1);">
                <div class="row g-5 align-items-start">

                    <!-- Logo + Deskripsi -->
                    <div class="col-lg-4 col-md-10">
                        <a href="{{ route('welcome') }}" class="d-flex align-items-center mb-3">
                            <img src="{{ asset('img/logo-dkis.png') }}" 
                                alt="Logo DKIS" 
                                class="logo-dkis">
                        </a>

                        <p class="text-white">
                            Dinas Komunikasi dan Informatika Kota Cirebon (DKIS) — pusat informasi, layanan digital,
                            serta pengembangan teknologi komunikasi pemerintahan Kota Cirebon.
                        </p>

                        <h5 class="text-white mt-4 mb-2"><i class="fas fa-clock text-white me-2"></i>Jam Layanan</h5>
                        <p class="text-white mb-1">Senin – Jumat : 08.00 - 16.00 WIB</p>
                        <p class="text-white">Sabtu – Minggu : Libur</p>
                    </div>

                    <!-- Kontak -->
                    <div class="col-lg-4 col-md-5">
                        <h4 class="text-white mb-4"><i class="fas fa-building text-white me-2"></i>Kontak & Alamat</h4>

                        <p class="text-white d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-white me-2 mt-1"></i>
                            Jalan DR. Sudarsono Nomor 40, Kelurahan Kesambi, Kecamatan Kesambi, Kota Cirebon
                        </p>
                        <p class="text-white mb-1"><i class="fas fa-phone-alt text-white me-2"></i>Telp : 02318804620</p>
                        <p class="text-white mb-4"><i class="fas fa-envelope text-white me-2"></i>Email : dkis@cirebonkota.go.id</p>
                    </div>

                    <!-- Google Maps Dark -->
                    <div class="col-lg-4 col-md-5">
                        <h4 class="text-white mb-4"><i class="fas fa-map text-white me-2"></i>Lokasi DKIS</h4>
                        <div class="map-darkmode">
                            <iframe width="100%" height="260" loading="lazy" allowfullscreen
                                src="https://www.google.com/maps?q=Jalan+DR.+Sudarsono+Nomor+40,+Kesambi,+Cirebon&output=embed"
                                style="border:0; filter: invert(90%) hue-rotate(180deg) brightness(80%);">
                            </iframe>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Footer End -->

       <!-- Copyright Start -->
        <div class="container-fluid copyright py-3" style="background:#000;">
            <div class="container-fluid px-5 py-3">
                <div class="row g-3 align-items-center">

                    <div class="col-md-6 text-center text-md-start">
                        <span class="text-white">
                            <i class="fas fa-copyright text-light me-2"></i>
                            Hak Cipta © <span id="year"></span> DKIS. Semua Hak Dilindungi.
                        </span>
                    </div>

                    <div class="col-md-6 text-center text-md-end text-white">
                        Dibuat & Dikembangkan oleh 
                        <a class="text-white fw-bold border-bottom" target="_blank" href="https://dkis.cirebonkota.go.id/">DKIS</a>
                    </div>

                </div>
            </div>
        </div>
        <!-- Copyright End -->

       <!-- Pusat Bantuan Floating Button -->
        <button id="helpToggle"
        class="btn btn-info btn-lg-square rounded-circle d-flex align-items-center justify-content-center shadow-lg"
        style="width:55px; height:55px; position: fixed; bottom: 25px; right: 25px; z-index: 999; transition:0.3s;">
        <span class="icon-outline-custom" style="position:relative; display:inline-block;">
                <i class="fa-regular fa-user fs-4 text-white"></i>
                <i class="fa-solid fa-headset fs-4 text-white" style="position:absolute; top:-3px; left:0; opacity:.55;"></i>
        </span>
        </button>

        <!-- Floating Pusat Bantuan -->
        <div class="help-floating">

            <div class="help-item">
                <a href="{{ route('help-center.index') }}"
                class="child-btn bg-primary"
                title="Pusat Bantuan">
                    <i class="fas fa-question-circle text-white"></i>
                </a>
            </div>

            <div class="help-item">
                <a href="https://wa.me/02318804620"
                target="_blank"
                class="child-btn bg-success"
                title="Hubungi via WhatsApp">
                    <i class="fab fa-whatsapp text-white"></i>
                </a>
            </div>

            <div class="help-item">
                <a href="mailto:dkis@cirebonkota.go.id"
                class="child-btn bg-danger"
                title="Kirim Email ke Admin">
                    <i class="fas fa-envelope text-white"></i>
                </a>
            </div>

            <div class="help-item">
                <a href="https://instagram.com/dkiskotacirebon"
                target="_blank"
                class="child-btn"
                style="background:#d6249f;"
                title="Instagram Resmi">
                    <i class="fab fa-instagram text-white"></i>
                </a>
            </div>


        </div>