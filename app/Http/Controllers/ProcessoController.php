<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processo;
use App\Models\Assunto; // Certifique-se de ter este Model se usar a tabela de assuntos
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // Necessário instalar: composer require barryvdh/laravel-dompdf

class ProcessoController extends Controller
{
    public function index(Request $request)
    {
        $query = Processo::query()
            ->with(['estado', 'tecnica'])
            ->withCount('aditamentos');

        /* ==========================
           FILTRO: PESQUISA
        ========================== */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numero_processo', 'like', "%$search%")
                    ->orWhere('requerente', 'like', "%$search%")
                    ->orWhere('origem', 'like', "%$search%");
            });
        }

        /* ==========================
           FILTRO: ESTADO
        ========================== */
        if ($request->filled('estado')) {
            $query->whereHas('estado', function ($q) use ($request) {
                $q->where('descricao', $request->estado);
            });
        }

        /* ==========================
           TÉCNICA VÊ SÓ OS SEUS
           Proteção ?-> adicionada para evitar erro se não houver user logado
        ========================== */
        if (Auth::user()?->perfil === 'tecnica') {
            $query->where('tecnica_id', Auth::id());
        }

        $processos = $query
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('processos.index', compact('processos'));
    }

    public function show($id)
    {
        $processo = Processo::with([
            'estado',
            'tecnica',
            'aditamentos.pecas',
            'historico',
            'oficios'
        ])->findOrFail($id);

        return view('processos.show', compact('processo'));
    }

    /* ============================================================
       NOVOS MÉTODOS PARA OFÍCIOS (PDF)
    ============================================================ */

    /**
     * Exibe o formulário de criação de Ofício
     */
    public function createOficio()
    {
        // Carrega os processos para o dropdown do formulário
        $processos = Processo::orderBy('numero_processo')->get();

        // Se já tiver a tabela de assuntos:
        // $assuntos = Assunto::all(); 

        return view('processos.oficios', compact('processos'));
    }

    /**
     * Processa os dados do formulário e gera o PDF
     */
    public function generatePDF(Request $request)
    {
        // 1. Validação simples
        $request->validate([
            'processo_id' => 'required|exists:processos,id',
            'assunto' => 'required|string',
            'conteudo' => 'required|string',
        ]);

        // 2. Busca os dados necessários
        $processo = Processo::with('tecnica')->findOrFail($request->processo_id);

        // Aqui simulamos o ID do aditamento conforme sua lógica
        // No futuro, você buscará o ID real do aditamento criado
        $aditamento_id = "ADT-" . date('Y') . "/" . rand(100, 999);

        $data = [
            'numero_processo' => $processo->numero_processo,
            'aditamento_id'   => $aditamento_id,
            'tecnica_nome'    => $processo->tecnica_nome ?? ($processo->tecnica->nome ?? 'Não atribuído'),
            'assunto'         => $request->assunto,
            'conteudo'        => $request->conteudo,
            'data_atual'      => date('d/m/Y')
        ];

        // 3. Gera o PDF usando a view dedicada
        $pdf = Pdf::loadView('pdf.oficio', $data);

        // 4. Retorna o PDF (stream abre no navegador, download força o baixar)
        return $pdf->stream('Oficio_' . str_replace('/', '-', $processo->numero_processo) . '.pdf');
    }
}
