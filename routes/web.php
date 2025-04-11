<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PersoonController;

Route::get('/klanten', [PersoonController::class, 'index'])->name('klanten.index');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/testview', function () {
    return view('klanten.index');
});

