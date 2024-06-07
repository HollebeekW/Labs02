<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserOrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserGame;
use App\Http\Middleware\CheckIsGameOwner;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Route::resource('games', GameController::class);
Route::resource('games', GameController::class)->parameters(['games' => 'game:slug'])->except('show', 'edit');
Route::get('/games/{game:slug}', [GameController::class, 'show'])->middleware(CheckUserGame::class)->name('games.show');
Route::get('/games/{game:slug}/edit', [GameController::class, 'edit'])->middleware(CheckIsGameOwner::class)->name('games.edit');
Route::get('/games/{game:slug}/history', [GameController::class, 'showHistory'])->middleware(CheckUserGame::class)->name('games.history');

Route::post('/games/search', [GameController::class, 'search'])->name('games.search');

Route::post('/games/{game:slug}/orders', [UserOrderController::class, 'store'])->name('user_orders.store');

Route::post('/games/{game:slug}', [GameController::class, 'destroy'])->name('games.destroy'); //couldn't get delete working, so using post instead

require __DIR__.'/auth.php';
