<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/auth/session', [LoginController::class, 'createSession'])->name('auth.session');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
