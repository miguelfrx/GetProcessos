<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

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
}
