<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProcessoController extends Controller
{
    // Mostrar formulário
    public function create()
    {
        return view('cadastros.criar');
    }

    // Guardar novo processo
    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'estado' => 'required|in:verde,amarelo,vermelho',
            'anexos.*' => 'file|max:5120',
        ]);

        $anexosNomes = [];

        // Guardar anexos
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                $nome = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('public/anexos', $nome);
                $anexosNomes[] = $nome;
            }
        }

        // Inserir na base de dados (sem 'num')
        DB::table('todoscadastros')->insert([
            'nome' => $request->nome,
            'email' => $request->email,
            'estado' => $request->estado,
            'anexos' => implode(',', $anexosNomes),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('paginamain')->with('success', 'Processo criado com sucesso!');
    }
}
