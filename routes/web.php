<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AnexoController;

// ==========================
// AUTH
// ==========================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ==========================
// PÁGINA PRINCIPAL
// ==========================
Route::middleware('auth')->group(function() {

    Route::get('/paginamain', [MainController::class, 'index'])->name('paginamain');

    Route::get('/todos-cadastros', [MainController::class, 'Cadastros'])->name('todos.cadastros');
    Route::get('/tratar-cadastros', [MainController::class, 'Cadastros'])->name('tratar.cadastros');

    // ==========================
    // ROTAS CADASTRO
    // ==========================
    Route::get('/cadastros/criar', [CadastroController::class, 'create'])->name('cadastros.create');
    Route::post('/cadastros', [CadastroController::class, 'store'])->name('cadastros.store');
    Route::get('/cadastros/{id}', [CadastroController::class, 'show'])->name('cadastros.show');
    Route::put('/cadastros/{id}', [CadastroController::class, 'update'])->name('atualizar.cadastro');
    Route::patch('/cadastros/{id}/estado', [CadastroController::class, 'updateEstado'])->name('cadastros.updateEstado');

    // Download de anexos
    Route::get('/anexos/download/{id}', [AnexoController::class, 'download'])->name('download.anexo');

    // Upload de anexos para um cadastro específico
    Route::post('/cadastros/{cadastro}/anexos', [AnexoController::class, 'store'])->name('anexos.store');

    // Bloquear acesso GET a esta rota
    Route::get('/cadastros/{id}/estado', function($id){
        return redirect()->back()->with('error', 'Acesso inválido.');
    });

});

Route::get('/', function () {
    return view('welcome');
});
