<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterGuruController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PengajuanPklmagangController;
use App\Http\Controllers\Admin\PengajuanMagangMahasiswaController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Siswa\PengajuanSiswaController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PembimbingDashboardController;
use App\Http\Controllers\Siswa\SiswaProfileController;
use App\Http\Controllers\Siswa\PresensiSiswaController;
use App\Http\Controllers\Admin\SiswaProfileController as AdminSiswaProfileController;
use App\Http\Controllers\Magang\PengajuanMagangController;
use App\Http\Controllers\Magang\MagangProfileController;
use App\Http\Controllers\MagangDashboardController;
use App\Http\Controllers\Magang\PresensiMagangController;
use App\Http\Controllers\Magang\FeedbackController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Magang\TugasController as MagangTugasController;
use App\Http\Controllers\Pembimbing\PembimbingPresensiController;
use App\Http\Controllers\Pembimbing\DailyReportController;
use App\Http\Controllers\Pembimbing\PenilaianAkhirController;
use App\Http\Controllers\Magang\MagangPenilaianAkhirController;
use App\Http\Controllers\Magang\MagangDailyReportController;
use App\Http\Controllers\Pembimbing\TugasController as PembimbingTugasController;
use App\Http\Controllers\Pembimbing\BimbinganPesertaController as PembimbingAreaController;
/*
|--------------------------------------------------------------------------
| Public / Guest Route
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('welcome');
});

Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

/*
|--------------------------------------------------------------------------
| Auth (hanya untuk user yang belum login)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Register Guru (Khusus)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisterGuruController::class, 'showForm'])
        ->name('register');

    Route::post('/register', [RegisterGuruController::class, 'register'])
        ->name('register.store');

    // Validasi data guru (AJAX)
    Route::post('/cek-guru', [RegisterGuruController::class, 'cekDataGuru'])
        ->name('cek-guru');
});




/*
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
*/

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot-password.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('forgot-password.send');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset-password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.update');

Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])
    ->name('auth.change-password');
Route::post('/change-password', [UserController::class, 'updatePassword'])
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

// Halaman notifikasi verifikasi
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Klik link verifikasi
Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);

    // Cek hash agar sesuai
    if (! hash_equals(sha1($user->getEmailForVerification()), $hash)) {
        abort(403);
    }

    // Sudah diverifikasi
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('success', 'Email sudah diverifikasi. Silakan login.');
    }

    // Tandai email sudah diverifikasi
    $user->markEmailAsVerified();

    return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Silakan login.');
})->name('verification.verify');

// Kirim ulang link verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Link verifikasi baru telah dikirim!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Logout (khusus user login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Universal Dashboard Redirect Based on Role
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','verified'])->get('/dashboard', function () {
    return match(auth()->user()->role_id) {
        1 => redirect()->route('admin.dashboard'),
        2 => redirect()->route('pembimbing.dashboard'),
        3 => redirect()->route('guru.dashboard'),
        4 => redirect()->route('siswa.dashboard'),
        5 => redirect()->route('magang.dashboard'),
        default => redirect()->route('magang.dashboard'),
    };
})->name('dashboard');




/*
|--------------------------------------------------------------------------
| Dashboard View per Role
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:1'])->get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::middleware(['auth','role:2'])->get('/pembimbing/dashboard', [PembimbingDashboardController::class, 'index'])->name('pembimbing.dashboard');

Route::middleware(['auth','verified','role:3','guru_verified'])->get('/guru/dashboard', function () {
    return view('guru.dashboard');
})->name('guru.dashboard');

Route::middleware(['auth','role:4'])->get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard');

Route::middleware(['auth','verified','role:5', 'magang_verified'])->get('/magang/dashboard', [MagangDashboardController::class, 'index'])->name('magang.dashboard');

    // Pengajuan Magang
    Route::get('/pengajuan/{id}', [App\Http\Controllers\PengajuanController::class, 'show'])->name('pengajuan.show');

    // Pengajuan PKL
    Route::get('/pengajuan/{id}', [App\Http\Controllers\PengajuanPklController::class, 'show'])->name('pengajuan.show');


/*
|--------------------------------------------------------------------------
| SISWA Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:4'])->prefix('siswa')->name('siswa.')->group(function() {
    // PENGAJUAN CRUD
    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [PengajuanSiswaController::class,'index'])->name('index');
        Route::get('/create', [PengajuanSiswaController::class,'create'])->name('create');
        Route::post('/store', [PengajuanSiswaController::class,'store'])->name('store');
        Route::get('/{id}/edit', [PengajuanSiswaController::class,'edit'])->name('edit');
        Route::put('/{id}', [PengajuanSiswaController::class,'update'])->name('update');
        Route::get('/{pengajuan}', [PengajuanSiswaController::class,'detail'])->name('detail');
    });

    // PROFILE SISWA
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [SiswaProfileController::class,'index'])->name('index');
        Route::put('/update', [SiswaProfileController::class,'update'])->name('update');
    });

    // PRESENSI
    Route::prefix('presensi')->name('presensi.')->group(function () {
        Route::get('/', [PresensiSiswaController::class,'index'])->name('index');
        Route::get('/create', [PresensiSiswaController::class,'create'])->name('create');
        Route::post('/store', [PresensiSiswaController::class,'store'])->name('store');
    });
});

Route::middleware(['profile.complete'])->group(function () {
    Route::get('/pengajuan/create', [PengajuanSiswaController::class, 'create'])
        ->name('siswa.pengajuan.create');

    Route::post('/pengajuan/store', [PengajuanSiswaController::class, 'store'])
        ->name('siswa.pengajuan.store');
});

Route::middleware(['auth','role:1'])->prefix('admin')->name('admin.')->group(function() {

    // USERS CRUD
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        // APPROVE GURU
        Route::post('/{user}/approve-guru', [UserController::class, 'approveGuru'])
            ->name('approve-guru');
        // REJECT GURU
        Route::post('/{user}/reject-guru', [UserController::class, 'rejectGuru'])
            ->name('reject-guru');
        // Kirim Email Verifikasi Ulang
        Route::post('/{user}/send-verify', [UserController::class, 'sendVerify'])
            ->name('sendVerify');

    });

    // ROLES CRUD
    Route::prefix('roles')->name('roles.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });

     // SEKOLAH CRUD
    Route::prefix('sekolah')->name('sekolah.')->group(function () {
    Route::get('/', [SekolahController::class, 'index'])->name('index');
    Route::get('/create', [SekolahController::class, 'create'])->name('create');
    Route::post('/', [SekolahController::class, 'store'])->name('store');
    Route::get('/{sekolah}', [SekolahController::class, 'show'])->name('show');
    Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])->name('edit');
    Route::put('/{sekolah}', [SekolahController::class, 'update'])->name('update');
    Route::delete('/{sekolah}', [SekolahController::class, 'destroy'])->name('destroy');
});

    // BIDANG CRUD
    Route::prefix('bidang')->name('bidang.')->group(function () {
        Route::get('/', [BidangController::class, 'index'])->name('index');
        Route::get('/create', [BidangController::class, 'create'])->name('create');
        Route::post('/', [BidangController::class, 'store'])->name('store');
        Route::get('/{bidang}/edit', [BidangController::class, 'edit'])->name('edit');
        Route::put('/{bidang}', [BidangController::class, 'update'])->name('update');
        Route::delete('/{bidang}', [BidangController::class, 'destroy'])->name('destroy');
        
    Route::get('/{bidang}', [BidangController::class, 'show'])->name('show');
    });

    // PEGAWAI CRUD
Route::prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/', [PegawaiController::class, 'index'])->name('index');
    Route::get('/create', [PegawaiController::class, 'create'])->name('create');
    Route::post('/', [PegawaiController::class, 'store'])->name('store');
    Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('edit');
    Route::put('/{pegawai}', [PegawaiController::class, 'update'])->name('update');
    Route::delete('/{pegawai}', [PegawaiController::class, 'destroy'])->name('destroy');
    
    Route::get('/{pegawai}', [PegawaiController::class, 'show'])->name('show');

    Route::get('/{pegawai}/create-user', [PegawaiController::class, 'createUser'])
    ->name('create-user');

Route::post('/{pegawai}/store-user', [PegawaiController::class, 'storeUser'])
    ->name('store-user');

});

// PENGAJUAN PKL/MAGANG CRUD
Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
    Route::get('/', [PengajuanPklmagangController::class, 'index'])->name('index');
    Route::get('/create', [PengajuanPklmagangController::class, 'create'])->name('create');
    Route::post('/', [PengajuanPklmagangController::class, 'store'])->name('store');
    Route::get('/{pengajuan}/edit', [PengajuanPklmagangController::class, 'edit'])->name('edit');
    Route::put('/{pengajuan}', [PengajuanPklmagangController::class, 'update'])->name('update');
    Route::delete('/{pengajuan}', [PengajuanPklmagangController::class, 'destroy'])->name('destroy');
    Route::get('/{pengajuan}', [PengajuanPklmagangController::class, 'show'])->name('show');

});

// ADMIN PENGAJUAN MAGANG MAHASISWA
Route::prefix('pengajuan-magang')->name('pengajuan-magang.')->group(function() {

    Route::get('/', [PengajuanMagangMahasiswaController::class, 'index'])->name('index');
    Route::get('/create', [PengajuanMagangMahasiswaController::class, 'create'])->name('create');
    Route::post('/store', [PengajuanMagangMahasiswaController::class, 'store'])->name('store');
    Route::get('/{pengajuan}/edit', [PengajuanMagangMahasiswaController::class, 'edit'])->name('edit');
    Route::put('/{pengajuan}', [PengajuanMagangMahasiswaController::class, 'update'])->name('update');
    Route::delete('/{pengajuan}', [PengajuanMagangMahasiswaController::class, 'destroy'])->name('destroy');
    Route::get('/{pengajuan}', [PengajuanMagangMahasiswaController::class, 'show'])->name('show');

    // Approve / Reject
    Route::post('/{pengajuan}/approve', [PengajuanMagangMahasiswaController::class, 'approve'])->name('approve');
    Route::post('/{pengajuan}/reject', [PengajuanMagangMahasiswaController::class, 'reject'])->name('reject');
});

// PEMBIMBING CRUD
Route::prefix('pembimbing')->name('pembimbing.')->group(function () {

    Route::get('/', [PembimbingController::class,'index'])->name('index');

    Route::get('/create', [PembimbingController::class,'create'])->name('create');
    Route::post('/', [PembimbingController::class,'store'])->name('store');

    Route::get('/{pembimbing}', [PembimbingController::class,'show'])
        ->whereNumber('pembimbing')
        ->name('show');

    Route::get('/{pembimbing}/edit', [PembimbingController::class,'edit'])
        ->whereNumber('pembimbing')
        ->name('edit');

    Route::put('/{pembimbing}', [PembimbingController::class,'update'])
        ->whereNumber('pembimbing')
        ->name('update');

    Route::delete('/{pembimbing}', [PembimbingController::class,'destroy'])
        ->whereNumber('pembimbing')
        ->name('destroy');
});

// PENEMPATAN CRUD
Route::prefix('penempatan')->name('penempatan.')->group(function () {
    Route::get('/', [PenempatanController::class,'index'])->name('index');
    Route::get('/create', [PenempatanController::class,'create'])->name('create');
    Route::post('/', [PenempatanController::class,'store'])->name('store');
    Route::get('/{penempatan}/edit', [PenempatanController::class,'edit'])->name('edit');
    Route::put('/{penempatan}', [PenempatanController::class,'update'])->name('update');
    Route::delete('/{penempatan}', [PenempatanController::class,'destroy'])->name('destroy');
});

Route::get('/siswa', [AdminSiswaProfileController::class, 'index'])
    ->name('siswa.index');

Route::get('/siswa/{id}', [AdminSiswaProfileController::class, 'show'])
    ->name('siswa.show');

});


/*
|--------------------------------------------------------------------------
| Bimbingan Pembimbing Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:2'])->prefix('pembimbing')->name('pembimbing.')->group(function() {
    
    Route::prefix('bimbingan-peserta')->name('bimbingan-peserta.')->group(function () {
        Route::get('/', [PembimbingAreaController::class, 'index'])->name('index');
        Route::get('/bimbingan-peserta/{id}', [PembimbingAreaController::class, 'show'])->name('show');});

    Route::prefix('verifikasi-presensi')
        ->name('verifikasi-presensi.')
        ->group(function () {

        Route::get('/', [PembimbingPresensiController::class, 'index'])
            ->name('index');

        Route::put('/{id}', [PembimbingPresensiController::class, 'update'])
            ->name('update');
    });

    Route::prefix('verifikasi-laporan')->name('verifikasi-laporan.')->group(function () {
        Route::get('/', [DailyReportController::class, 'index'])->name('index');
        Route::put('/{id}', [DailyReportController::class, 'update'])->name('update');
    });

    // TUGAS CRUD
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [PembimbingTugasController::class, 'index'])->name('index');
        Route::get('/create', [PembimbingTugasController::class, 'create'])->name('create');
        Route::post('/', [PembimbingTugasController::class, 'store'])->name('store');
        Route::get('/{id}', [PembimbingTugasController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [PembimbingTugasController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PembimbingTugasController::class, 'update'])->name('update');
        Route::delete('/{id}', [PembimbingTugasController::class, 'destroy'])->name('destroy');

        // Assign siswa ke tugas
        Route::get('/{id}/assign', [PembimbingTugasController::class, 'assignForm'])->name('assignForm');
        Route::post('/{id}/assign', [PembimbingTugasController::class, 'assign'])->name('assign');

        // Daftar submit peserta
        Route::get('/{id}/submissions', [PembimbingTugasController::class, 'submissions'])->name('submissions');

        // Form penilaian
        Route::get('/submit/{id}/gradeForm', [PembimbingTugasController::class, 'gradeForm'])->name('gradeForm');

        // Proses penilaian
        Route::post('/submit/{id}/grade', [PembimbingTugasController::class, 'grade'])->name('grade');

    });
    // PEMBIMBING
Route::prefix('penilaian_akhir')->name('penilaian_akhir.')->group(function () {

    Route::get('/', 
        [PenilaianAkhirController::class, 'index']
    )->name('index');
    Route::get('/{siswa}/form', 
        [PenilaianAkhirController::class, 'form']
    )->name('form');

    Route::post('/{siswa}', 
        [PenilaianAkhirController::class, 'store']
    )->name('store');
});
});



/*
|--------------------------------------------------------------------------
| Pendaftaran Magang (Mahasiswa / Public)
|--------------------------------------------------------------------------
*/
Route::get('/daftar-magang', [PengajuanMagangController::class, 'create'])
    ->name('magang.daftar');

Route::post('/daftar-magang', [PengajuanMagangController::class, 'store'])
    ->name('magang.store');


Route::middleware(['auth','role:5'])->prefix('magang')->name('magang.')->group(function() {
    // Profile Magang
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [MagangProfileController::class, 'index'])->name('index');
        Route::put('/update', [MagangProfileController::class, 'update'])->name('update');
    });

    // PRESESNSI MAGANG
    Route::prefix('presensi')->name('presensi.')->group(function () {
        Route::get('/', [PresensiMagangController::class, 'index'])->name('index');
        Route::get('/create', [PresensiMagangController::class, 'create'])->name('create');
        Route::post('/store', [PresensiMagangController::class, 'store'])->name('store');
    });

    Route::prefix('daily-report')->name('daily-report.')->group(function () {
    Route::get('/', [MagangDailyReportController::class, 'index'])->name('index');
    Route::get('/create', [MagangDailyReportController::class, 'create'])->name('create');
    Route::post('/', [MagangDailyReportController::class, 'store'])->name('store');
    Route::get('/{id}', [MagangDailyReportController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [MagangDailyReportController::class, 'edit'])->name('edit');
    Route::put('/{id}', [MagangDailyReportController::class, 'update'])->name('update');
});


    // Feedback CRUD khusus Magang
    Route::prefix('feedback')->name('feedback.')->group(function () {
        // Lihat semua feedback Magang sendiri
        Route::get('/', [FeedbackController::class, 'index'])->name('index');

        // Lihat detail feedback
        Route::get('/{id}', [FeedbackController::class, 'show'])->name('show');

        // Buat feedback baru
        Route::post('/store', [FeedbackController::class, 'store'])->name('store');

        // Update feedback sendiri
        Route::put('/{id}', [FeedbackController::class, 'update'])->name('update');
         Route::put('{id}/toggle-status', [FeedbackController::class, 'toggleStatus'])->name('feedback.toggle-status');

    });

    // Tugas untuk Magang
    Route::prefix('tugas')->name('tugas.')->group(function () {
        Route::get('/', [MagangTugasController::class, 'index'])->name('index');
        Route::get('/{id}', [MagangTugasController::class, 'show'])->name('show');
        Route::get('/{id}/submit', [MagangTugasController::class, 'submitForm'])->name('submitForm');
        Route::post('/{id}/submit', [MagangTugasController::class, 'submit'])->name('submit');
    });

    // PESERTA MAGANG / PKL
Route::prefix('penilaian_akhir')->name('penilaian_akhir.')->group(function () {

    Route::get('penilaian_akhir', 
        [MagangPenilaianAkhirController::class, 'index']
    )->name('magang.penilaian_akhir.index');
});

});