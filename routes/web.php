<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//create game routes
Route::get('/games/index', [\App\Http\Controllers\GameController::class, 'index'])->name('games.index');
Route::get('/games/create', [\App\Http\Controllers\GameController::class, 'create'])->name('games.create');
Route::post('/games', [\App\Http\Controllers\GameController::class, 'store'])->name('games.store');
Route::get('/games/{game}', [\App\Http\Controllers\GameController::class, 'show'])->name('games.show');

require __DIR__.'/auth.php';
