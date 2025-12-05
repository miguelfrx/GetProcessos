<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CadastroController extends Controller
{
    public function show($id)
    {
        $cadastro = DB::table('TodosCadastros')->where('id', $id)->first();

        if (!$cadastro) {
            abort(404, 'Cadastro não encontrado');
        }

        return view('cadastros.show', compact('cadastro'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'nome' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'contacto' => 'nullable|string|max:50',
        'estado' => 'required|in:verde,amarelo,vermelho,a tratar',
        'responsavel' => 'nullable|string|max:255',
    ]);

    DB::table('TodosCadastros')
        ->where('id', $id)
        ->update([
            'nome' => $request->nome,
            'email' => $request->email,
            'contacto' => $request->contacto,
            'estado' => $request->estado,
            'responsavel' => $request->responsavel,
            'updated_at' => now(),
        ]);

    return redirect()->route('cadastros.show', $id)
                     ->with('success', 'Cadastro atualizado com sucesso!');
}

}

