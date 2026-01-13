<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processo;
use App\Models\Assunto;
use App\Models\EstadoProcesso;
use App\Models\Aditamento;
use App\Models\Processos;
use App\Models\Tecnica;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ProcessoController extends Controller
{
    /**
     * Lista todos os processos com filtros de pesquisa e estado
     */
    public function index(Request $request)
    {
        $query = Processos::with(['estado', 'tecnica'])
            ->withCount('aditamentos');

        // Filtro de Pesquisa (Nº EAmb, Requerente ou Nº CME)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numero_eamb', 'like', "%$search%")
                    ->orWhere('numero_cme', 'like', "%$search%")
                    ->orWhere('requerente', 'like', "%$search%");
            });
        }

        // Filtro por Estado (ID vindo do dropdown)
        if ($request->filled('estado')) {
            $query->where('estado_id', $request->estado);
        }

        $processos = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $estados = EstadoProcesso::all();

        return view('Processos.processos', compact('processos', 'estados'));
    }

    /**
     * Mostra os detalhes de um processo (Página: showprocessos.blade.php)
     */
    public function show($id)
    {
        // Carrega o processo com as relações para mostrar histórico e técnica
        $processo = Processos::with([
            'estado',
            'tecnica',
            'aditamentos.tecnica'
        ])->findOrFail($id);

        return view('Processos.showprocessos', compact('processo'));
    }

    /**
     * Regista um Aditamento, grava histórico e muda estado para "em Apreciação"
     */
    public function storeAditamento(Request $request, $id)
    {
        $processo = Processos::findOrFail($id);

        // 1. Cria o Aditamento na base de dados
        $processo->aditamentos()->create([
            'tecnica_id'   => $processo->tecnica_id, // Mantém a técnica par/ímpar original
            'descricao'    => $request->descricao ?? 'Início da análise técnica.',
            'estado_atual' => 'em Apreciação'
        ]);

        // 2. Atualiza o estado principal do processo para "em Apreciação" (ID 2)
        $processo->update([
            'estado_id' => 2
        ]);

        return redirect()->route('processos.show', $id)
            ->with('success', 'Aditamento registado com sucesso!');
    }

    /**
     * Gera o PDF automático com o modelo definido
     */
    public function generatePDF(Request $request)
    {
        // Validação dos dados que o PDF precisa
        $request->validate([
            'processo_id' => 'required|exists:processos,id',
            'assunto'     => 'required|string', // Virá da tabela de Assuntos futuramente
            'conteudo'    => 'required|string', // Caixa de texto
        ]);

        $processo = Processos::with(['tecnica', 'aditamentos'])->findOrFail($request->processo_id);

        // Preparação dos dados para o Blade do PDF
        $data = [
            'processo_cme'    => $processo->numero_cme ?? '---',
            'processo_eamb'   => $processo->numero_eamb,
            'data_entrada'    => $processo->data_entrada ? date('d/m/Y', strtotime($processo->data_entrada)) : '---',
            'id_aditamento'   => $processo->aditamentos->last()->id ?? 'N/A',
            'data_atual'      => date('d/m/Y'),
            'requerente'      => $processo->requerente,
            'assunto'         => $request->assunto,
            'conteudo'        => $request->conteudo,
            'tecnico_nome'    => $processo->tecnica->nome ?? 'Responsável Técnico',
            'tecnico_cargo'   => 'Técnico/a de Ambiente',
        ];

        // Carrega o PDF a partir de uma view específica para o layout do documento
        $pdf = Pdf::loadView('pdf.modelo_oficial', $data);
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Oficio_' . $processo->numero_eamb . '.pdf');
    }
}
