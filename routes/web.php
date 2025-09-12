<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdController;
use App\Models\Ad;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $ads = Ad::with(['user','primaryPhoto','photos'])->latest()->take(20)->get();
    return view('welcome', compact('ads'));
});

// Authentication routes
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('password/forgot', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        $ads = Ad::with(['user','primaryPhoto','photos'])
            ->where('user_id', Auth::id())
            ->latest()
            ->take(50)
            ->get();
        return view('home', compact('ads'));
    })->name('home');

    Route::get('ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::post('ads', [AdController::class, 'store'])->name('ads.store');
    Route::get('ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
});

// Public ad show route
Route::get('ads/{ad}', [AdController::class, 'show'])->name('ads.show');

// Admin login form
Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
