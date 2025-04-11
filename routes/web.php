<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReserveringController;
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
    Route::get('/reservering', [ReserveringController::class, 'index'])->name('reservering.index');
    Route::get('/reservering/{id}/edit', [ReserveringController::class, 'edit'])->name('reservering.edit');
    Route::get('/reservering/uitslagen', [ReserveringController::class, 'uitslagen'])->name('reservering.uitslagen');
    Route::post('/reservering/uitslagen', [ReserveringController::class, 'toonUitslagen'])->name('reservering.toonUitslagen');
    Route::put('/reservering/{id}', [ReserveringController::class, 'update'])->name('reservering.update');
});

require __DIR__.'/auth.php';
