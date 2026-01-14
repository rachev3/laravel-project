<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/movies');

Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');
