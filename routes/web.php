<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// sem necessidade de autenticação
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('authenticate');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'store'])->name('user.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        echo 'Página Inicial';
    })->name('home');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
