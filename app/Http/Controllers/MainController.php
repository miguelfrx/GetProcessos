<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    // Página principal com os contadores
    public function index()
    {
        $todosCadastrosCount = DB::table('TodosCadastros')->count();

        $tratarCadastrosCount = DB::table('TodosCadastros')
            ->where('Estado', 'amarelo') // agora é amarelo, não 'a tratar'
            ->count();

        return view('paginamain', compact('todosCadastrosCount', 'tratarCadastrosCount'));
    }


    // Página "Todos os Cadastros"
    public function todosCadastros(Request $request)
    {
        $query = DB::table('TodosCadastros');

        // Filtro por estado
        if ($request->filled('estado') && in_array($request->estado, ['verde','amarelo','vermelho','a tratar'])) {
            $query->where('Estado', $request->estado);
        }

        // Pesquisa por nome ou email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $cadastros = $query->get();

        return view('cadastros.cadastros', compact('cadastros'));
    }

    // Página "A Tratar"
        public function tratarCadastros()
    {
        $cadastros = DB::table('TodosCadastros')
            ->where('Estado', 'amarelo') // filtra apenas amarelo
            ->get();

        // contagem para o badge
        $tratarCadastrosCount = $cadastros->count();

        return view('cadastros.cadastros', compact('cadastros', 'tratarCadastrosCount'));
}
}
