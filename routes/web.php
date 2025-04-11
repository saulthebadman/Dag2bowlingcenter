<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UitslagOverzichtController;
use App\Http\Controllers\SpelerController;
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

    // Zorg ervoor dat deze route correct is ingesteld
    Route::resource('uitslagoverzicht', UitslagOverzichtController::class);

    Route::get('/uitslagoverzicht/{id}/show', [UitslagOverzichtController::class, 'showByReservering'])->name('uitslagoverzicht.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes voor Spelers
    Route::get('/spelers', [SpelerController::class, 'index'])->name('spelers.index');
    Route::get('/spelers/{id}/edit', [SpelerController::class, 'edit'])->name('spelers.edit');
    Route::put('/spelers/{id}', [SpelerController::class, 'update'])->name('spelers.update');
});

require __DIR__.'/auth.php';
