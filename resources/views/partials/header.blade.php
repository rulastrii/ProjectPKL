<!-- Navbar -->
      <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none" >
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
              <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
            </div>
            <div class="nav-item dropdown">
              @php
                  $user = Auth::user();
                  $foto = ($user && $user->siswaProfile && $user->siswaProfile->foto)
                          ? asset('uploads/foto_siswa/' . $user->siswaProfile->foto)
                          : asset('static/avatars/user-default.png');
              @endphp

              <a href="#" class="nav-link d-flex align-items-center lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                  <span class="avatar avatar-sm rounded-circle me-2" 
                        style="
                            background-image: url('{{ $foto }}');
                            background-size: cover;
                            background-position: center;
                            width: 32px;
                            height: 32px;
                            display: inline-block;
                        ">
                  </span>
    


                  <div class="d-none d-xl-block ps-2">
    <div>{{ $user->name ?? 'Guest' }}</div>

    <div class="mt-1 small text-secondary">
        {{ $user->role->name ?? 'No Role' }}

        @if($user->role_id == 2 && $user->pegawai && $user->pegawai->bidang)
            ({{ $user->pegawai->bidang->nama }})
        @endif
    </div>
</div>

              </a>

              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                @php
                    $profileRoute = match(auth()->user()->role_id) {
                        3 => route('guru.profile.index'),
                        4 => route('siswa.profile.index'),
                        5 => route('magang.profile.index'),
                        default => '#',
                    };
                @endphp
                <a href="{{ $profileRoute }}" class="dropdown-item">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
    Logout
</button>

                </form>

              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <div class="d-flex align-items-center justify-content-end">
              <!-- Tanggal & Jam Digital -->
              <div id="datetime" class="fw-bold large text-end me-3"></div>
          </div>
          </div>
        </div>
      </header>
      <script>
        function updateDateTime() {
            const dt = new Date();
            const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

            const dayName = days[dt.getDay()];
            const date = dt.getDate().toString().padStart(2,'0');
            const month = months[dt.getMonth()];
            const year = dt.getFullYear();

            const hours = dt.getHours().toString().padStart(2,'0');
            const minutes = dt.getMinutes().toString().padStart(2,'0');
            const seconds = dt.getSeconds().toString().padStart(2,'0');

            const formatted = `${dayName}, ${date} ${month} ${year} | ${hours}:${minutes}:${seconds}`;
            const datetimeEl = document.getElementById('datetime');

            if(datetimeEl) {
                datetimeEl.textContent = formatted;

                // Detect theme dari URL
                const urlParams = new URLSearchParams(window.location.search);
                const theme = urlParams.get('theme');

                if(theme === 'dark') {
                    datetimeEl.classList.remove('text-dark');
                    datetimeEl.classList.add('text-white');
                } else {
                    datetimeEl.classList.remove('text-white');
                    datetimeEl.classList.add('text-dark');
                }
            }
        }

        // Update setiap detik
        setInterval(updateDateTime, 1000);
        updateDateTime(); // initial
        </script>