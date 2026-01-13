<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\ProcessoController;

// ============================================================
// ROTAS PÚBLICAS (WELCOME & AUTH)
// ============================================================

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');


// ============================================================
// ROTAS PROTEGIDAS (APENAS UTILIZADORES LOGADOS)
// ============================================================
Route::middleware('auth')->group(function () {

    // --- PÁGINA PRINCIPAL E LISTAGENS ---
    Route::get('/paginamain', [MainController::class, 'index'])->name('paginamain');
    Route::get('/todos-cadastros', [MainController::class, 'Cadastros'])->name('todos.cadastros');
    Route::get('/tratar-cadastros', [MainController::class, 'Cadastros'])->name('tratar.cadastros');

    // --- PROCESSOS E OFÍCIOS (Ordem Corrigida) ---

    // 1. Rotas de Ofícios (Devem vir antes do {id} para evitar Erro 404)
    Route::get('/processos/oficios', [ProcessoController::class, 'createOficio'])->name('oficios.create');
    Route::post('/processos/oficios/gerar', [ProcessoController::class, 'generatePDF'])->name('oficios.generate');

    // 2. Listagem e Detalhes de Processos
    Route::get('/processos', [ProcessoController::class, 'index'])->name('processos.index');
    Route::get('/processos/{id}', [ProcessoController::class, 'show'])->name('processos.show');


    // --- GESTÃO DE CADASTROS ---
    Route::get('/cadastros/criar', [CadastroController::class, 'create'])->name('cadastros.create');
    Route::post('/cadastros', [CadastroController::class, 'store'])->name('cadastros.store');
    Route::get('/cadastros/{id}', [CadastroController::class, 'show'])->name('cadastros.show');
    Route::put('/cadastros/{id}', [CadastroController::class, 'update'])->name('atualizar.cadastro');
    Route::patch('/cadastros/{id}/estado', [CadastroController::class, 'updateEstado'])->name('cadastros.updateEstado');

    // Bloquear acesso GET direto à rota de alteração de estado
    Route::get('/cadastros/{id}/estado', function ($id) {
        return redirect()->back()->with('error', 'Acesso inválido.');
    });


    // --- ANEXOS ---
    Route::get('/anexos/download/{id}', [AnexoController::class, 'download'])->name('download.anexo');
    Route::post('/cadastros/{cadastro}/anexos', [AnexoController::class, 'store'])->name('anexos.store');


    Route::post('/processos/{id}/aditamento', [ProcessoController::class, 'storeAditamento'])->name('aditamentos.store');
});
