<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro de usuário
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Página principal com sidebar e badges
Route::get('/paginamain', [MainController::class, 'index'])
    ->middleware('auth')
    ->name('paginamain');

// Subitens da sidebar
Route::get('/todos-cadastros', [MainController::class, 'todosCadastros'])->middleware('auth');
Route::get('/tratar-cadastros', [MainController::class, 'tratarCadastros'])->middleware('auth');

// ✅ RAIZ APONTA PARA welcome.blade.php
Route::get('/', function () {
    return view('welcome');
});
