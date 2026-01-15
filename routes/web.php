<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\MoviePosterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminGenreController;
use App\Http\Controllers\Admin\AdminMovieController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');

    Route::post('/movies/{movie}/poster', [MoviePosterController::class, 'update'])
        ->middleware('can:updatePoster,movie')
        ->name('movies.poster.update');

    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('movies.reviews.store');
    Route::match(['put', 'patch'], '/movies/{movie}/reviews/{review}', [ReviewController::class, 'update'])->name('movies.reviews.update');
    Route::delete('/movies/{movie}/reviews/{review}', [ReviewController::class, 'destroy'])->name('movies.reviews.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'can:admin'])
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('movies', AdminMovieController::class)->except(['show']);
        Route::resource('genres', AdminGenreController::class)->except(['show']);
        Route::resource('users', AdminUserController::class)->except(['show']);
    });

require __DIR__.'/auth.php';
