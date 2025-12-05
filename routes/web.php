<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\ProcessoController;
use Nette\Schema\Processor;

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registro de usuário
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Página principal
Route::get('/paginamain', [MainController::class, 'index'])
    ->middleware('auth')
    ->name('paginamain');

// Subpáginas da sidebar Processos
Route::get('/todos-cadastros', [MainController::class, 'todosCadastros'])
    ->middleware('auth')
    ->name('todos.cadastros');

Route::get('/tratar-cadastros', [MainController::class, 'tratarCadastros'])
    ->middleware('auth')
    ->name('tratar.cadastros');

// Página inicial da aplicação
Route::get('/', function () {
    return view('welcome');
});

// Página de detalhes de um cadastro
Route::get('/cadastros/{id}', [CadastroController::class, 'show'])
    ->middleware('auth')
    ->name('cadastros.show');

// Formulário para criar novo processo
Route::get('/criar-processo', [ProcessoController::class, 'create'])
    ->middleware('auth')
    ->name('criar.processo');

// Guardar dados do novo processo
Route::post('/guardar-processo', [ProcessoController::class, 'store'])
    ->middleware('auth')
    ->name('guardar.processo');

    // Atualizar cadastro
Route::put('atualizar-processo', [ProcessoController::class, 'update'])
    ->middleware('auth')
    ->name('atualizar.cadastro');
