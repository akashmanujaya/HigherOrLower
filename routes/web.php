<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', [GameController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route for the initial shuffle when the game starts
Route::get('/game/shuffle', [GameController::class, 'shuffle'])->name('game.shuffle');

// Route for handling the user's guess ('higher' or 'lower')
Route::post('/game/next-card', [GameController::class, 'nextCard'])->name('game.nextCard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
