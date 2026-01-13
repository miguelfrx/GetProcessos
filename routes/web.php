<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\ProcessoController;

// ============================================================
// ROTAS PÚBLICAS
// ============================================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas de Registro (Caso precises)
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// ============================================================
// ROTAS PROTEGIDAS (AUTH)
// ============================================================

Route::middleware('auth')->group(function () {

    Route::get('/paginamain', [MainController::class, 'index'])->name('paginamain');

    // ================= PROCESSOS =================

    // 1. Listagem Geral
    Route::get('/processos', [ProcessoController::class, 'index'])->name('processos.index');

    // 2. Rota que estava em falta e causava o erro (oficios.create)
    // Se a tua sidebar aponta para aqui, ela tem de estar definida.
    Route::get('/processos/novo-oficio', [ProcessoController::class, 'index'])->name('oficios.create');

    // 3. Detalhe do Processo
    Route::get('/processos/{id}', [ProcessoController::class, 'show'])->name('processos.show');

    // 4. Ações (PDF e Aditamento)
    Route::post('/processos/{id}/pdf', [ProcessoController::class, 'generatePDF'])->name('processos.pdf');
    Route::post('/processos/{id}/aditamento', [ProcessoController::class, 'storeAditamento'])->name('aditamentos.store');

    // ================= CADASTROS =================
    Route::get('/todos-cadastros', [MainController::class, 'Cadastros'])->name('todos.cadastros');
    Route::get('/cadastros/criar', [CadastroController::class, 'create'])->name('cadastros.create');
    Route::post('/cadastros', [CadastroController::class, 'store'])->name('cadastros.store');
    Route::get('/cadastros/{id}', [CadastroController::class, 'show'])->name('cadastros.show');

    // ================= ANEXOS =================
    Route::get('/anexos/download/{id}', [AnexoController::class, 'download'])->name('download.anexo');
    Route::post('/cadastros/{cadastro}/anexos', [AnexoController::class, 'store'])->name('anexos.store');
});
