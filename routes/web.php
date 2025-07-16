<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AnasayfaController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

// === TASK 1: Anasayfa route ===
Route::get('/', [AnasayfaController::class, 'index'])->name('anasayfa');

// === TASK 2 ve 3: Blog CRUD route (auth ile korumalı) ===
Route::middleware(['auth'])->group(function () {
    Route::resource('bloglar', BlogController::class)->parameters([
        'bloglar' => 'blog'
    ]);

    // === Profile işlemleri ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// === Dashboard ===
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// === Breeze auth rotaları ===
require __DIR__.'/auth.php';
