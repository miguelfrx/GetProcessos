<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    // Página principal
    public function index()
    {
        // Contadores para os badges
        $todosCadastrosCount = DB::table('TodosCadastros')->count();
        $tratarCadastrosCount = DB::table('TodosCadastros')
            ->where('Estado', 'a tratar')
            ->count();

        return view('paginamain', compact('todosCadastrosCount', 'tratarCadastrosCount'));
    }

    // Todos os cadastros (com filtro e pesquisa)
    public function todosCadastros(Request $request)
    {
        $query = DB::table('TodosCadastros');

        // Filtro por estado, se enviado
        if ($request->has('estado') && in_array($request->estado, ['verde','amarelo','vermelho','a tratar'])) {
            $query->where('Estado', $request->estado);
        }

        // Filtro de pesquisa (nome ou email)
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nome', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $cadastros = $query->get();

        // Retorna a view correta (confere que a pasta e arquivo existam)
        return view('cadastroS.cadastros', compact('cadastros'));
    }

    // Cadastros "A Tratar"
    public function tratarCadastros()
    {
        $cadastros = DB::table('TodosCadastros')
            ->where('Estado', 'a tratar')
            ->get();

        return view('cadastros.cadastros', compact('cadastros'));
    }
}
