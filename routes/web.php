<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::get('/tracing-game',function () {
            return view('game.index'); // Ini mengarah ke 'resources/views/game/index.blade.php'
        })->name('tracing-game');

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::redirect('/dashboard', '/')->middleware('guest');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/mentors', [AdminDashboardController::class, 'mentors'])->name('mentors');
        Route::get('/murids', [AdminDashboardController::class, 'murids'])->name('murids');
        Route::get('/activities', [AdminDashboardController::class, 'activities'])->name('activities');
        Route::get('/content', [AdminDashboardController::class, 'content'])->name('content');
        Route::get('/soal-management', [AdminDashboardController::class, 'soalManagement'])->name('soal.management');
    });

    // Mentor Routes
    Route::middleware(['role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/murids', [MentorDashboardController::class, 'murids'])->name('murids');
        Route::get('/progress', [MentorDashboardController::class, 'progress'])->name('progress');
        Route::get('/soal', [MentorDashboardController::class, 'soal'])->name('soal');
        Route::get('/leaderboard', [MentorDashboardController::class, 'leaderboard'])->name('leaderboard');
        Route::get('/requests', [MentorDashboardController::class, 'requests'])->name('requests');
    });

    // Murid Routes
    Route::middleware(['role:murid'])->prefix('murid')->name('murid.')->group(function () {
        Route::get('/dashboard', [MuridDashboardController::class, 'index'])->name('dashboard');
        Route::get('/learning', [MuridDashboardController::class, 'learning'])->name('learning');
        Route::get('/games', [MuridDashboardController::class, 'games'])->name('games');
        Route::get('/progress', [MuridDashboardController::class, 'progress'])->name('progress');
        Route::get('/mentors', [MuridDashboardController::class, 'mentors'])->name('mentors');

        
    });
});

