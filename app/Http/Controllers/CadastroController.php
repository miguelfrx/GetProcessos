<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\EstadoCadastro;
use App\Models\HistoricoCadastro;
use Illuminate\Support\Facades\Auth;

class CadastroController extends Controller
{
    /**
     * Mostrar detalhe de um cadastro
     */
    public function show($id)
    {
        $cadastro = Cadastro::with(['anexos', 'estado'])->findOrFail($id);

        // Estados para os botões
        $estadoAguarda = EstadoCadastro::where('descricao', 'Aguardar Pagamento')->first();
        $estadoCorrecao = EstadoCadastro::where('descricao', 'Para Correção')->first();

        // Contadores (ex: sidebar / dashboard)
        $todosCadastrosCount = Cadastro::count();

        $aTratarCount = Cadastro::whereHas('estado', function ($q) {
            $q->where('descricao', 'a tratar');
        })->count();

        return view('cadastros.show', compact(
            'cadastro',
            'estadoAguarda',
            'estadoCorrecao',
            'todosCadastrosCount',
            'aTratarCount'
        ));
    }

    /**
     * Atualizar estado do cadastro
     */
    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado_id' => 'required|exists:estados_cadastros,id'
        ]);

        $cadastro = Cadastro::findOrFail($id);
        $novoEstado = EstadoCadastro::findOrFail($request->estado_id);

        $estadoAnterior = $cadastro->estado_id;

        // Atualizar estado
        $cadastro->estado_id = $novoEstado->id;
        $cadastro->save();

        // Guardar histórico
        HistoricoCadastro::create([
            'cadastro_id' => $cadastro->id,
            'data_hora' => now(),
            'id_user' => Auth::id(),
            'id_tecnico' => $cadastro->id_tecnico,
            'estado_anterior_id' => $estadoAnterior,
            'estado_atual_id' => $novoEstado->id,
        ]);

        return redirect()->back()->with('success', 'Estado atualizado com sucesso!');
    }
}
