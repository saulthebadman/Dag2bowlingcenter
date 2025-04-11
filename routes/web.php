<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReserveringController;
use Illuminate\Support\Facades\Route;
use App\Models\Reservering; // Add this to use the Reservering model

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $reserveringen = Reservering::with('user')
    ->where('user_id', auth()->id())
    ->orderBy('tijd')
    ->get();


    return view('dashboard', compact('reserveringen')); // Pass data to the view
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reservering routes
    Route::get('/reserveringen', [ReserveringController::class, 'index'])->name('reserveringen.index');
    Route::get('/reserveringen/create', [ReserveringController::class, 'create'])->name('reserveringen.create');
    Route::post('/reserveringen', [ReserveringController::class, 'store'])->name('reserveringen.store');
    Route::get('/reserveringen/{reservering}/edit', [ReserveringController::class, 'edit'])->name('reserveringen.edit');
    Route::patch('/reserveringen/{reservering}', [ReserveringController::class, 'update'])->name('reserveringen.update');

    // Route for confirmed reservations overview
    Route::get('/reserveringen/overzicht', [ReserveringController::class, 'confirmedReservations'])->name('reserveringen.overview');

    // Routes for editing and updating lane number
    Route::get('/reserveringen/{reservering}/edit-lane', [ReserveringController::class, 'editLane'])->name('reserveringen.edit-lane');
    Route::patch('/reserveringen/{reservering}/update-lane', [ReserveringController::class, 'updateLane'])->name('reserveringen.update-lane');
});

require __DIR__.'/auth.php';
