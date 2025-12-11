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
            'estado' => 'required|in:verde,amarelo,vermelho,a tratar',
            'anexos.*' => 'file|max:5120', // até 5MB por anexo
        ]);

        $anexosNomes = [];

        // Guardar anexos
        if ($request->hasFile('anexos')) {
            foreach ($request->file('anexos') as $file) {
                // Nome único
                $nome = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();

                // Guardar no storage/app/public/anexos
                $file->storeAs('public/anexos', $nome);

                // Guardar nome no array para a BD
                $anexosNomes[] = $nome;
            }
        }

        // Inserir na base de dados
        DB::table('cadastros')->insert([
            'nome' => $request->nome,
            'email' => $request->email,
            'estado' => $request->estado,
            'anexos' => json_encode($anexosNomes), // <--- FORMATADO como JSON
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('paginamain')
            ->with('success', 'Processo criado com sucesso!');
    }


    // Mostrar processo + anexos
    public function show($id)
    {
        $cadastro = DB::table('cadastros')->where('id', $id)->first();

        if (!$cadastro) {
            abort(404, "Processo não encontrado");
        }

        // Converter JSON → array
        $cadastro->anexos = $cadastro->anexos ? json_decode($cadastro->anexos, true) : [];

        return view('cadastros.show', compact('cadastro'));
    }

    // Download do anexo
    public function downloadAnexo($filename)
    {
        $path = storage_path("app/public/anexos/" . $filename);

        if (!file_exists($path)) {
            abort(404, "Ficheiro não encontrado");
        }

        return response()->download($path);
    }
}
