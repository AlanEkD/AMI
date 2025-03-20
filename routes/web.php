<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\MarcasController;
use App\Http\Controllers\ModelosController;


// En routes/web.php
Route::get('/articulos/export', [App\Http\Controllers\ArticuloController::class, 'export'])
    ->name('articulos.export');

// En routes/web.php
Route::get('/AMI-dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::resource('modelos', ModelosController::class);


Route::resource('marcas', MarcasController::class);


Route::resource('articulos', ArticuloController::class);


Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
