<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cadastro;
use App\Models\Estado;
use App\Models\EstadoCadastro;

class MainController extends Controller
{
    // Página principal com os contadores
    public function index()
    {
        $CadastrosCount = Cadastro::count();

        // Pega o id do estado "amarelo"
        $estadoAmarelo = EstadoCadastro::where('descricao', 'amarelo')->first();

        $tratarCadastrosCount = 0;
        if ($estadoAmarelo) {
            $tratarCadastrosCount = Cadastro::where('estado_id', $estadoAmarelo->id)->count();
        }

        return view('paginamain', compact('CadastrosCount', 'tratarCadastrosCount'));
    }

    // Página "Todos os Cadastros"
    public function cadastros(Request $request)
    {
        $query = Cadastro::query()->with('estado'); // carrega o estado relacionado

        // Filtro por estado
        if ($request->filled('estado')) {
            $estado = EstadoCadastro::where('descricao', $request->estado)->first();
            if ($estado) {
                $query->where('estado_id', $estado->id);
            }
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
        $estadoAmarelo = EstadoCadastro::where('descricao', 'amarelo')->first();
        $cadastros = collect();

        if ($estadoAmarelo) {
            $cadastros = Cadastro::where('estado_id', $estadoAmarelo->id)->with('estado')->get();
        }

        $tratarCadastrosCount = $cadastros->count();

        return view('cadastros.cadastros', compact('cadastros', 'tratarCadastrosCount'));
    }
}
