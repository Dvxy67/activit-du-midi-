<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
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
});

// Routes pour les activités (nécessite d'être connecté)
Route::middleware('auth')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::post('/activities/{activity}/register', [ActivityController::class, 'register'])->name('activities.register');
    Route::delete('/activities/{activity}/unregister', [ActivityController::class, 'unregister'])->name('activities.unregister');
});

require __DIR__.'/auth.php';
