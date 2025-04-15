<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UitslagOverzichtController;
use App\Http\Controllers\SpelerController;
use App\Http\Controllers\ReserveringController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('uitslagoverzicht', UitslagOverzichtController::class);

    Route::get('/uitslagoverzicht/{id}/show', [UitslagOverzichtController::class, 'showByReservering'])->name('uitslagoverzicht.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes voor Spelers
    Route::get('/spelers', [SpelerController::class, 'index'])->name('spelers.index');
    Route::get('/spelers/{id}/edit', [SpelerController::class, 'edit'])->name('spelers.edit');
    Route::put('/spelers/{id}', [SpelerController::class, 'update'])->name('spelers.update');

    // Routes voor Reserveringen
    Route::get('/reservering', [ReserveringController::class, 'index'])->name('reservering.index');
    Route::get('/reservering/{id}/edit', [ReserveringController::class, 'edit'])->name('reservering.edit');
    Route::get('/reservering/uitslagen', [ReserveringController::class, 'uitslagen'])->name('reservering.uitslagen');
    Route::post('/reservering/uitslagen', [ReserveringController::class, 'toonUitslagen'])->name('reservering.toonUitslagen');
    Route::put('/reservering/{id}', [ReserveringController::class, 'update'])->name('reservering.update');
});

require __DIR__.'/auth.php';
