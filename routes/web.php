<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Events\Verified;

use App\Models\User;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RegisterGuruController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\BidangController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\PembimbingController;
use App\Http\Controllers\Admin\MagangMahasiswaController;
use App\Http\Controllers\Admin\PklSiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\PresensiRekapController;
use App\Http\Controllers\Admin\HelpCenterController;

use App\Http\Controllers\Admin\PengajuanPklController as AdminPengajuanController;
use App\Http\Controllers\Admin\PengajuanMagangMahasiswaController;
use App\Http\Controllers\Admin\PenempatanController;
use App\Http\Controllers\Pembimbing\BimbinganPesertaController as PembimbingAreaController;
use App\Http\Controllers\Pembimbing\PembimbingPresensiController;
use App\Http\Controllers\Pembimbing\DailyReportController;
use App\Http\Controllers\Pembimbing\TugasController as PembimbingTugasController;
use App\Http\Controllers\Pembimbing\PenilaianAkhirController;
use App\Http\Controllers\Pembimbing\PembimbingSertifikatController;
use App\Http\Controllers\Pembimbing\PembimbingRekapController;

use App\Http\Controllers\Guru\PengajuanPklController as GuruPengajuanController;
use App\Http\Controllers\Guru\SiswaPklController as SiswaPklController;
use App\Http\Controllers\Guru\GuruProfileController;
use App\Http\Controllers\Guru\GuruSekolahController;

use App\Http\Controllers\Siswa\SiswaProfileController;
use App\Http\Controllers\Siswa\PresensiSiswaController;
use App\Http\Controllers\Siswa\SiswaDailyReportController;
use App\Http\Controllers\Siswa\SiswaTugasController;
use App\Http\Controllers\Siswa\PenilaianController;
use App\Http\Controllers\Siswa\SiswaSertifikatController;

use App\Http\Controllers\Magang\PengajuanMagangController;
use App\Http\Controllers\Magang\MagangProfileController;
use App\Http\Controllers\Magang\PresensiMagangController;
use App\Http\Controllers\Magang\MagangDailyReportController;
use App\Http\Controllers\Magang\TugasController as MagangTugasController;
use App\Http\Controllers\Magang\MagangPenilaianAkhirController;
use App\Http\Controllers\Magang\MagangSertifikatController;
use App\Http\Controllers\Magang\FeedbackController;
use App\Http\Controllers\Magang\MagangRiwayatController;


use App\Http\Controllers\PageController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PembimbingDashboardController;
use App\Http\Controllers\MagangDashboardController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\VerifikasiSertifikatController;
use App\Http\Controllers\PublicHelpCenterController;



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
| Register Guru (Khusus)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/register-guru', [RegisterGuruController::class, 'showForm'])
        ->name('register');

    Route::post('/register-guru', [RegisterGuruController::class, 'register'])
        ->name('register.store');

});


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
*/

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForm'])->name('forgot-password.form');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('forgot-password.send');

    Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])->name('reset-password.form');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.update');

    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('auth.change-password');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');


    Route::get('/pusat-bantuan', [PublicHelpCenterController::class, 'index'])
        ->name('help-center.index');

    Route::post('/pusat-bantuan', [PublicHelpCenterController::class, 'store'])
        ->name('help-center.request');



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
        if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }

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

Route::middleware(['auth','verified','role:3','guru_verified'])
    ->get('/guru/dashboard', [GuruDashboardController::class, 'index'])
    ->name('guru.dashboard');

Route::middleware(['auth','role:4'])->get('/siswa/dashboard', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard');

Route::middleware(['auth','verified','role:5', 'magang_verified'])->get('/magang/dashboard', [MagangDashboardController::class, 'index'])->name('magang.dashboard');

/*
|--------------------------------------------------------------------------
| SISWA Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:4'])->prefix('siswa')->name('siswa.')->group(function() {
    

    // PROFILE SISWA
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [SiswaProfileController::class,'index'])->name('index');
        Route::put('/update', [SiswaProfileController::class,'update'])->name('update');
    });

    // PRESENSI SISWA PKL
    Route::prefix('presensi')->name('presensi.')->group(function () {
        // Daftar presensi
        Route::get('/', [PresensiSiswaController::class,'index'])->name('index');

        // Form absensi hari ini
        Route::get('/create', [PresensiSiswaController::class,'create'])->name('create');

        // Simpan presensi masuk / pulang
        Route::post('/store', [PresensiSiswaController::class,'store'])->name('store');
    });

    
    // DAILY REPORT SISWA PKL
    Route::prefix('daily-report')->name('daily-report.')->group(function () {
        Route::get('/', [SiswaDailyReportController::class, 'index'])->name('index');
        Route::get('/create', [SiswaDailyReportController::class, 'create'])->name('create');
        Route::post('/', [SiswaDailyReportController::class, 'store'])->name('store');
        Route::get('/{id}', [SiswaDailyReportController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SiswaDailyReportController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SiswaDailyReportController::class, 'update'])->name('update');
    });

      // TUGAS SISWA PKL
    Route::prefix('tugas')->name('tugas.')->group(function () {
        // Daftar tugas
        Route::get('/', [SiswaTugasController::class, 'index'])->name('index');

        // Detail tugas
        Route::get('/{id}', [SiswaTugasController::class, 'show'])->name('show');

        // Form submit tugas
        Route::get('/{id}/submit', [SiswaTugasController::class, 'submitForm'])->name('submitForm');

        // Proses submit tugas
        Route::post('/{id}/submit', [SiswaTugasController::class, 'submit'])->name('submit');
    });

    Route::prefix('penilaian')->name('penilaian.')->group(function () {
        // Daftar penilaian siswa sendiri
        Route::get('/', [PenilaianController::class, 'index'])->name('index');

        // Detail penilaian
        Route::get('/{id}', [PenilaianController::class, 'show'])->name('show');
    
    });
    
    // Sertifikat Magang
    Route::prefix('sertifikat')->name('sertifikat.')->group(function() {
        Route::get('/', [SiswaSertifikatController::class, 'index'])->name('index');
    
    });

});

/*
|--------------------------------------------------------------------------
| GURU Routes (ROLE 3)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:3', 'guru_verified'])->prefix('guru')->name('guru.')->group(function () {

    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [GuruPengajuanController::class, 'index'])->name('index');
        Route::get('/create', [GuruPengajuanController::class, 'create'])->name('create');
        Route::post('/store', [GuruPengajuanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [GuruPengajuanController::class, 'edit'])->name('edit');
        Route::post('/{id}/add-siswa', [GuruPengajuanController::class, 'addSiswa'])->name('addSiswa');
        Route::post('/{id}/submit', [GuruPengajuanController::class, 'submit'])->name('submit');
        Route::get('/{id}', [GuruPengajuanController::class, 'show'])->name('show');   
    });

    Route::prefix('profile')->name('profile.')->middleware(['auth'])->group(function () {
        Route::get('/', [GuruProfileController::class, 'index'])->name('index');
        Route::put('/update', [GuruProfileController::class, 'update'])->name('update');
        Route::post('/upload-dokumen', [GuruProfileController::class, 'uploadDokumen'])->name('uploadDokumen');
    });

    // Route sekolah
    Route::prefix('sekolah')->name('sekolah.')->group(function() {
        Route::get('/', [GuruSekolahController::class, 'index'])->name('index');
        Route::post('/store', [GuruSekolahController::class, 'store'])->name('store'); // untuk modal tambah sekolah
        Route::get('/{id}/edit', [GuruSekolahController::class, 'edit'])->name('edit');
        Route::put('/{id}/update', [GuruSekolahController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [GuruSekolahController::class, 'destroy'])->name('destroy');
        
        // Tambahkan route show
        Route::get('/{id}', [GuruSekolahController::class, 'show'])->name('show');
    });


    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaPklController::class, 'index'])->name('index');
        Route::get('/{id}', [SiswaPklController::class, 'show'])->name('show');
    });

});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

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

    Route::prefix('help')->name('help.')->group(function () {
        Route::get('/', [HelpCenterController::class, 'index'])->name('index');
        Route::get('/{help}', [HelpCenterController::class, 'show'])->name('show');
        Route::post('/{help}/unblock', [HelpCenterController::class, 'unblock'])
    ->name('unblock');

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
        Route::get('/{pegawai}', [PegawaiController::class, 'show'])->name('show');
        Route::get('/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('edit');
        Route::put('/{pegawai}', [PegawaiController::class, 'update'])->name('update');
        Route::delete('/{pegawai}', [PegawaiController::class, 'destroy'])->name('destroy');
        Route::get('/{pegawai}/create-user', [PegawaiController::class, 'createUser'])->name('create-user');
        Route::post('/{pegawai}/store-user', [PegawaiController::class, 'storeUser'])->name('store-user');

    });

    // PENGAJUAN PKL CRUD
    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('/', [AdminPengajuanController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [AdminPengajuanController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [AdminPengajuanController::class, 'update'])->name('update');
        Route::get('/{id}', [AdminPengajuanController::class, 'show'])->name('show'); 
       
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
    
        
    Route::get('magang-mahasiswa', [MagangMahasiswaController::class,'index'])->name('magang-mahasiswa.index');
    Route::get('magang-mahasiswa/{id}', [MagangMahasiswaController::class,'show'])->name('magang-mahasiswa.show');

    });

    Route::prefix('magang-mahasiswa')->name('magang-mahasiswa.')->group(function() {
        Route::get('/', [MagangMahasiswaController::class,'index'])->name('index');
        Route::get('/{id}', [MagangMahasiswaController::class,'show'])->name('show');

    });

    Route::prefix('pkl-siswa')->name('pkl-siswa.')->group(function() {
        Route::get('/', [PklSiswaController::class, 'index'])->name('index');
        Route::get('/{id}', [PklSiswaController::class, 'show'])->name('show');
    });

    Route::prefix('guru')->name('guru.')->group(function() {
        Route::get('/', [GuruController::class, 'index'])->name('index');
        Route::get('/{id}', [GuruController::class, 'show'])->name('show');
    });


    // PEMBIMBING CRUD
    Route::prefix('pembimbing')->name('pembimbing.')->group(function () {
        Route::get('/', [PembimbingController::class,'index'])->name('index');
        Route::get('/create', [PembimbingController::class,'create'])->name('create');
        Route::post('/', [PembimbingController::class,'store'])->name('store');
        Route::get('/{pembimbing}', [PembimbingController::class,'show'])->whereNumber('pembimbing')->name('show');
        Route::get('/{pembimbing}/edit', [PembimbingController::class,'edit'])->whereNumber('pembimbing')->name('edit');
        Route::put('/{pembimbing}', [PembimbingController::class,'update'])->whereNumber('pembimbing')->name('update');
        Route::delete('/{pembimbing}', [PembimbingController::class,'destroy'])->whereNumber('pembimbing')->name('destroy');
    
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

    // Admin group (pastikan pakai auth middleware)
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/', [PageController::class, 'index'])->name('index');
        Route::get('/create', [PageController::class, 'create'])->name('create');
        Route::post('/', [PageController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PageController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PageController::class, 'update'])->name('update');
        Route::delete('/{id}', [PageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('presensi')->name('presensi.')->group(function () {
        Route::get(
            '/export-pdf',
            [PresensiRekapController::class, 'exportPdf']
        )->name('pdf');
         Route::get('/export-excel', [PresensiRekapController::class, 'exportExcel'])
        ->name('excel');

        Route::get('/', 
            [PresensiRekapController::class, 'index']
        )->name('index');

        Route::get('/{siswa_id}', 
            [PresensiRekapController::class, 'detail']
        )->name('detail');
    });


});





/*
|--------------------------------------------------------------------------
| Pembimbing Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:2'])->prefix('pembimbing')->name('pembimbing.')->group(function() {

    Route::prefix('bimbingan-peserta')->name('bimbingan-peserta.')->group(function () {
        Route::get('/', [PembimbingAreaController::class, 'index'])->name('index');
        Route::get('/bimbingan-peserta/{id}', [PembimbingAreaController::class, 'show'])->name('show');
    
    });

    Route::prefix('verifikasi-presensi')->name('verifikasi-presensi.')->group(function () {
        Route::get('/', [PembimbingPresensiController::class, 'index'])->name('index');
        Route::put('/{id}', [PembimbingPresensiController::class, 'update'])->name('update');
    
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
    Route::prefix('penilaian-akhir')->name('penilaian-akhir.')->group(function () {
        Route::get('/', [PenilaianAkhirController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [PenilaianAkhirController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PenilaianAkhirController::class, 'update'])->name('update');
        Route::get('/{id}', [PenilaianAkhirController::class, 'show'])->name('show');
    
    });

    // Sertifikat CRUD
    Route::prefix('sertifikat')->name('sertifikat.')->group(function () {
        Route::get('/', [PembimbingSertifikatController::class, 'index'])->name('index');
        Route::get('/create', [PembimbingSertifikatController::class, 'create'])->name('create');
        Route::post('/', [PembimbingSertifikatController::class, 'store'])->name('store');
        Route::get('/{id}', [PembimbingSertifikatController::class, 'show'])->name('show');
        Route::delete('/{id}', [PembimbingSertifikatController::class, 'destroy'])->name('destroy');
    
    });

    // =========================
    // REKAP PEMBIMBING
    // =========================
    Route::prefix('rekap')->name('rekap.')->group(function () {

        // Rekap semua peserta bimbingan
        Route::get('/', [PembimbingRekapController::class, 'index'])
            ->name('index');

        // Detail rekap per peserta
        Route::get('/{siswaId}', [PembimbingRekapController::class, 'show'])
            ->name('show');

        // Cetak PDF
        Route::get('/{siswaId}/pdf', [PembimbingRekapController::class, 'pdf'])
            ->name('pdf');
    });

});


/*
|--------------------------------------------------------------------------
| Pendaftaran Magang (Mahasiswa / Public)
|--------------------------------------------------------------------------
*/

    Route::get('/daftar-magang', [PengajuanMagangController::class, 'create'])->name('magang.daftar');
    Route::post('/daftar-magang', [PengajuanMagangController::class, 'store'])->name('magang.store');


/*
|--------------------------------------------------------------------------
| Magang Routes
|--------------------------------------------------------------------------
*/

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

    // PESERTA MAGANG 
    Route::prefix('penilaian-akhir')->name('penilaian-akhir.')->group(function () {
        Route::get('/', [MagangPenilaianAkhirController::class, 'index'])->name('index');
    
    });

    // Sertifikat Magang
    Route::prefix('sertifikat')->name('sertifikat.')->group(function() {
        Route::get('/', [MagangSertifikatController::class, 'index'])->name('index');
    
    });

    // Riwayat Magang
    Route::prefix('riwayat')->name('riwayat.')->group(function () {
        Route::get('/', [MagangRiwayatController::class, 'index'])->name('index');
        Route::get('/{id}', [MagangRiwayatController::class, 'show'])->name('show');
    });


});


/*
|--------------------------------------------------------------------------
| 
|--------------------------------------------------------------------------
*/

    Route::get('/sertifikat/verifikasi/{token}', [VerifikasiSertifikatController::class, 'show'])->name('sertifikat.verifikasi');
    Route::get('/search', [WelcomeController::class, 'search'])->name('search');

    // Public page
    Route::get('/{slug}', [PageController::class, 'show'])->name('show');
