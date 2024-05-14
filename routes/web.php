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
Route::get('/games/{game}/edit', [\App\Http\Controllers\GameController::class, 'edit'])->name('games.edit');
Route::post('/games/{game}', [\App\Http\Controllers\GameController::class, 'update'])->name('games.update');

//Game routes
Route::get('games/{game}/game', [\App\Http\Controllers\GameController::class, 'startGame'])->name('games.start');
Route::post('games/{game}/nextRound', [\App\Http\Controllers\GameController::class, 'nextRound'])->name('games.nextRound');

require __DIR__.'/auth.php';
