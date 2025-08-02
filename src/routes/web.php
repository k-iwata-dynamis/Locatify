<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [MapController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/map/test', [MapController::class, 'test'])->middleware(['auth', 'verified'])->name('map.test');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Google OAuth routes
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Map location endpoint (Ajax用)
Route::post('/dashboard/location', [MapController::class, 'getCurrentLocation'])->name('dashboard.location');

// 周辺のレストランするためのエンドポイント
Route::post('dashboard/nearbyRestaurants',[MapController::class,'searchNearByRestaurants'])->name('dashboard.nearbyRestaurants');



require __DIR__.'/auth.php';
