<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\AnexoCadastro;
use App\Models\EstadoCadastro;
use App\Models\HistoricoCadastro; // importa o model do histórico
use Illuminate\Support\Facades\Storage;

class CadastroController extends Controller
{
    public function show($id)
    {
        $cadastro = Cadastro::with('anexos', 'estado')->findOrFail($id);

        // Buscar estados para os botões
        $estadoAguarda = EstadoCadastro::where('descricao', 'Aguardar Pagamento')->first();
        $estadoCorrecao = EstadoCadastro::where('descricao', 'Para Correção')->first();

        return view('cadastros.show', compact('cadastro', 'estadoAguarda', 'estadoCorrecao'));
    }

    public function updateEstado(Request $request, $id)
    {
        $cadastro = Cadastro::findOrFail($id);

        // Verifica se o estado_id existe e é válido
        $novoEstado = EstadoCadastro::find($request->estado_id);
        if ($novoEstado) {

            // Guarda o estado anterior
            $estadoAnterior = $cadastro->estado_id;

            // Atualiza o cadastro
            $cadastro->estado_id = $novoEstado->id;
            $cadastro->save();

            // Regista no histórico
            HistoricoCadastro::create([
                'cadastro_id' => $cadastro->id,
                'data_hora' => now(),
                'id_user' => auth()->Null, // se não houver login, podes colocar null
                'id_tecnico' => $cadastro->id_tecnico,
                'estado_anterior_id' => $estadoAnterior,
                'estado_atual_id' => $novoEstado->id
            ]);

            return redirect()->back()->with('success', 'Estado atualizado com sucesso!');
        }

        return redirect()->back()->with('error', 'Estado inválido.');
    }
}
