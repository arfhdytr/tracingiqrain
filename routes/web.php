<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Mentor\MentorDashboardController;
use App\Http\Controllers\Auth\RegisterMuridController;
use App\Http\Controllers\Auth\RegisterMentorController;
use App\Http\Controllers\Auth\ForgotPasswordMuridController;
use App\Models\TingkatanIqra;

use App\Http\Controllers\Murid\ModulController;
use App\Http\Controllers\Murid\GameController;
use App\Http\Controllers\Murid\EvaluasiController;
use App\Http\Controllers\Murid\MentorController;


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

    // Forgot Password for Murid (with security question)
    Route::get('/password/murid/request', [ForgotPasswordMuridController::class, 'showUsernameForm'])
        ->name('password.murid.request');
    Route::post('/password/murid/check', [ForgotPasswordMuridController::class, 'checkUsername'])
        ->name('password.murid.check');
    Route::post('/password/murid/verify', [ForgotPasswordMuridController::class, 'verifyAnswer'])
        ->name('password.murid.verify');
    Route::post('/password/murid/reset', [ForgotPasswordMuridController::class, 'resetPassword'])
        ->name('password.murid.reset');
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

        // Modul
        Route::get('/modul/{tingkatan_id}', [ModulController::class, 'index'])->name('modul.index');
        Route::get('/modul/{tingkatan_id}/video', [ModulController::class, 'video'])->name('modul.video');
        Route::get('/modul/{tingkatan_id}/materi/{materi_id}', [ModulController::class, 'materi'])->name('modul.materi');
        Route::post('/modul/progress', [ModulController::class, 'updateProgress'])->name('modul.progress');
        Route::get('/modul/completed', [ModulController::class, 'getCompletedModuls'])->name('modul.completed');

        // Games
        Route::get('/games/{tingkatan_id}', [GameController::class, 'index'])->name('games.index');

        Route::get('/games/{tingkatan_id}/memory-card', [GameController::class, 'memoryCard'])->name('games.memory-card');    
        Route::post('/game/save-score', [GameController::class, 'saveScore'])
        ->name('game.saveScore');

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

    