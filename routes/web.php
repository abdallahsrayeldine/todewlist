<?php

use App\Http\Controllers\PlantController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Auth/Login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [PlantController::class, 'index'])->name('plants.index');
    Route::get('/plants/{id}', [PlantController::class, 'show'])->name('plants.show');
    Route::post('/dashboard', [PlantController::class, 'store'])->name('plants.store');
    Route::patch('/dashboard/{id}', [PlantController::class, 'update'])->name('plants.update');
});

require __DIR__ . '/auth.php';
