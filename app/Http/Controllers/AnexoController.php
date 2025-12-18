<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cadastro;
use App\Models\EstadoCadastro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AnexoController extends Controller
{
    public function store(Request $request, $cadastroId)
    {
        $request->validate([
            'ficheiro' => 'required|file|max:30720', // 30MB
        ]);

        $cadastro = Cadastro::findOrFail($cadastroId);

        $file = $request->file('ficheiro');

        // Nome original
        $originalName = $file->getClientOriginalName();

        // Extensão (.pdf, .jpg, etc.)
        $extensao = '.' . strtolower($file->getClientOriginalExtension());

        // Nome final
        $filename = time() . '_' . $originalName;

        // Guardar ficheiro
        $file->storeAs('anexos', $filename, 'public');

        // Criar registo na BD
        $cadastro->anexos()->create([
            'ficheiro'      => $filename,
            'tipo'          => $extensao,   // automático
            'caminho'       => 'anexos/' . $filename,
            'data_entrada'  => now(),
        ]);

        // --- Atualizar estado automaticamente ---
        $estadoAtual = $cadastro->estado->descricao; // estado atual do cadastro

        // Sequência de estados
        $sequenciaEstados = [
            'Submetido' => 'Para Correção',
            'Para Correção' => 'Aguardar Pagamento',
            'Aguardar Pagamento' => 'Pagamento Efectuado',
            'Pagamento Efectuado' => 'Concluído',
            'Concluído' => 'Concluído' // mantém-se no final
        ];

        $novoEstadoDescricao = $sequenciaEstados[$estadoAtual] ?? $estadoAtual;

        $novoEstado = DB::table('estados_cadastros')
            ->where('descricao', $novoEstadoDescricao)
            ->first();
            
        // Atualizar cadastro
        $cadastro->estado_id = $novoEstado->id;
        $cadastro->save();

        return redirect()->back()->with('success', 'Anexo enviado com sucesso! Estado atualizado para: ' . $novoEstado->descricao);
    }
}
