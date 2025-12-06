<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use App\Http\Controllers\Auth\RegisterMuridController;
use App\Http\Controllers\Auth\RegisterMentorController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Models\TingkatanIqra;

use App\Http\Controllers\Murid\ModulController;
use App\Http\Controllers\Murid\GameController;
use App\Http\Controllers\Murid\EvaluasiController;
use App\Http\Controllers\Murid\MentorController;

use App\Livewire\Murid\MuridUpdateProfile;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::redirect('/dashboard', '/')->middleware('guest');

Route::get('/ini', function () {
    return view('ini');
})->name('ini');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Custom)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // Murid Registration (2 steps)
    Route::get('/register/murid', [RegisterMuridController::class, 'showRegistrationForm'])
        ->name('register.murid');
    Route::post('/register/murid', [RegisterMuridController::class, 'register'])
        ->name('register.murid.post');
    Route::get('/register/murid/preferensi', [RegisterMuridController::class, 'showPreferensiForm'])
        ->name('register.murid.preferensi');

    // Mentor Registration
    Route::get('/register/mentor', [RegisterMentorController::class, 'showRegistrationForm'])
        ->name('register.mentor');
    Route::post('/register/mentor', [RegisterMentorController::class, 'register'])
        ->name('register.mentor.post');
    Route::get('/register/mentor/pending', [RegisterMentorController::class, 'showPendingPage'])
        ->name('register.mentor.pending');

    // Registration Success Page
    Route::get('/register/success', function () {
        return view('auth.register-success');
    })->name('register.success');

    // 1. Halaman Input Username Awal
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showUsernameForm'])
        ->name('password.request');
    Route::post('/forgot-password/check', [ForgotPasswordController::class, 'checkUsername'])
        ->name('password.check');

    // 2. Alur Murid
    Route::get('/forgot-password/murid/question', [ForgotPasswordController::class, 'showMuridQuestion'])
        ->name('password.murid.question');
    Route::post('/forgot-password/murid/verify', [ForgotPasswordController::class, 'verifyMuridAnswer'])
        ->name('password.murid.verify');

    // 3. Alur Mentor
    Route::get('/forgot-password/mentor/email', [ForgotPasswordController::class, 'showMentorEmailForm'])
        ->name('password.mentor.email');
    Route::post('/forgot-password/mentor/send', [ForgotPasswordController::class, 'verifyMentorEmail'])
        ->name('password.mentor.send');

    // 4. Halaman Reset Password Akhir (Shared)
    // Route untuk Murid (tanpa token di URL) & Mentor (dengan token dari email)
    Route::get('/reset-password/{token?}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset.form'); // Route name harus sesuai config password reset laravel

    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])
        ->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        // approval
        Route::get('/approval', [AdminDashboardController::class, 'approval'])->name('approval');
        // murid
        Route::prefix('murid')->name('murid.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'murid'])->name('index');
            Route::get('/create', [AdminDashboardController::class, 'muridCreate'])->name('create');
            Route::get('/{murid}/edit', [AdminDashboardController::class, 'muridEdit'])->name('edit');
        });
        // mentor
        Route::prefix('mentor')->name('mentor.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'mentor'])->name('index');
            Route::get('/create', [AdminDashboardController::class, 'mentorCreate'])->name('create');
            Route::get('/{mentor}/edit', [AdminDashboardController::class, 'mentorEdit'])->name('edit');
        });
        // video
        Route::prefix('video')->name('video.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'video'])->name('index');
            Route::get('/create', [AdminDashboardController::class, 'videoCreate'])->name('create');
            Route::get('/{videoPembelajaran}/view', [AdminDashboardController::class, 'videoView'])->name('view');
            Route::get('/{videoPembelajaran}/edit', [AdminDashboardController::class, 'videoEdit'])->name('edit');
        });
        Route::prefix('tracking')->name('tracking.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'tracking'])->name('index');
            Route::get('/{murid}', [AdminDashboardController::class, 'trackingDetail'])->name('detail');
        });
        Route::get('/activities', [AdminDashboardController::class, 'activities'])->name('activities');
        Route::get('/content', [AdminDashboardController::class, 'content'])->name('content');
        Route::get('/soal-management', [AdminDashboardController::class, 'soalManagement'])->name('soal.management');
    });

    // Mentor Routes
    Route::middleware(['role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
        // Murid Management
        Route::prefix('murid')->name('murid.')->group(function () {
            Route::get('/', [MentorDashboardController::class, 'murid'])->name('index');
            Route::get('/create', [MentorDashboardController::class, 'muridCreate'])->name('create');
            Route::get('/{murid}/edit', [MentorDashboardController::class, 'muridEdit'])->name('edit');

            // Download Template
            Route::get('/download-template', [MentorDashboardController::class, 'downloadTemplate'])->name('download-template');
        });
        Route::prefix('permintaan')->name('permintaan.')->group(function () {
            Route::get('/', [MentorDashboardController::class, 'permintaan'])->name('index');
        });
        Route::prefix('laporan-kelas')->name('laporan-kelas.')->group(function () {
            Route::get('/', [MentorDashboardController::class, 'laporanKelas'])->name('index');
        });
        // Laporan Murid
        Route::prefix('laporan-murid')->name('laporan-murid.')->group(function () {
            Route::get('/', [MentorDashboardController::class, 'laporanMurid'])->name('index');
            Route::get('/{murid}', [MentorDashboardController::class, 'laporanMuridDetail'])->name('detail');
        });
    });

    // Murid Routes
    Route::middleware(['auth', 'role:murid'])->prefix('murid')->name('murid.')->group(function () {

        Route::get('/pilih-iqra', function () {
            $tingkatans = TingkatanIqra::orderBy('level')->get();
            return view('pages.murid.pilih-iqra', compact('tingkatans'));
        })->name('pilih-iqra');

        Route::get('/lengkapi-data', [RegisterMuridController::class, 'showSetupPreferensiForm'])
        ->name('setup.preferensi');
    
        Route::post('/lengkapi-data', [RegisterMuridController::class, 'storeSetupPreferensi'])
            ->name('setup.preferensi.post');

        // Update profile
        Route::get('/profile', MuridUpdateProfile::class)->name('profile');

        // Modul
        Route::post('/modul/progress', [ModulController::class, 'updateProgress'])->name('modul.progress');
        Route::get('/modul/completed', [ModulController::class, 'getCompletedModuls'])->name('modul.completed');

        Route::get('/modul/{tingkatan_id}', [ModulController::class, 'index'])->name('modul.index');
        Route::get('/modul/{tingkatan_id}/video', [ModulController::class, 'video'])->name('modul.video');
        Route::get('/modul/{tingkatan_id}/materi/{materi_id}', [ModulController::class, 'materi'])->name('modul.materi');

        // Games
        Route::get('/games/{tingkatan_id}', [GameController::class, 'index'])->name('games.index');

        Route::get('/games/{tingkatan_id}/memory-card', [GameController::class, 'memoryCard'])->name('games.memory-card');
        Route::post('/game/save-score', [GameController::class, 'saveScore'])->name('game.saveScore');

        Route::get('/games/{tingkatan_id}/tracing', [GameController::class, 'tracing'])->name('games.tracing');
        Route::get('/games/{tingkatan_id}/labirin', [GameController::class, 'labirin'])->name('games.labirin');
        Route::get('/games/{tingkatan_id}/drag-drop', [GameController::class, 'dragDrop'])->name('games.drag-drop');

        // Evaluasi
        Route::get('/evaluasi/{tingkatan_id}', [EvaluasiController::class, 'index'])->name('evaluasi.index');
        Route::get('/evaluasi/{tingkatan_id}/leaderboard', [EvaluasiController::class, 'leaderboard'])->name('evaluasi.leaderboard');

        // Mentor
        Route::get('/mentor', [MentorController::class, 'index'])->name('mentor.index');
        Route::post('/mentor/request/{mentor_id}', [MentorController::class, 'requestBimbingan'])->name('mentor.request');
    });


});


