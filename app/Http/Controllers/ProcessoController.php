<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processos;
use App\Models\EstadoProcesso;
use App\Models\Assuntos;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ProcessoController extends Controller
{
    // Listagem de processos
    public function index(Request $request)
    {
        $query = Processos::with(['estado', 'tecnica']);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('numero_eamb', 'like', "%$search%")
                    ->orWhere('requerente', 'like', "%$search%");
            });
        }
        $processos = $query->orderByDesc('created_at')->paginate(15);
        $estados = EstadoProcesso::all();
        return view('Processos.processos', compact('processos', 'estados'));
    }

    // Mostrar detalhes do processo
    public function show($id)
    {
        $processo = Processos::with(['estado', 'tecnica', 'aditamentos.tecnica'])->findOrFail($id);
        return view('Processos.showprocessos', compact('processo'));
    }

    // BOTÃO GERAR ADITAMENTO: Transita para "em Apreciação"
    public function storeAditamento(Request $request, $id)
    {
        $processo = Processos::with('estado')->findOrFail($id);
        $estadoOriginal = $processo->estado->nome ?? 'Pendente';

        // Regista a transição automática
        $processo->aditamentos()->create([
            'processo_id'           => $processo->id,
            'tecnica_id'            => $processo->tecnica_id,
            'data_registo'          => now(),
            'estado_inicial'        => $estadoOriginal,
            'estado_atual'          => 'em Apreciação',
            'historico_aditamentos' => 'Processo colocado em "Aguardar Validação" e transitado automaticamente para "em Apreciação".',
            'descricao'             => 'Início da fase de análise técnica.',
        ]);

        // Atualiza para ID 2 (em Apreciação)
        $processo->update(['estado_id' => 2]);

        return redirect()->back()->with('success', 'Aditamento gerado! O processo está agora em apreciação.');
    }

    // GERAR PDF: Cria histórico e transita para "Concluído"
    public function generatePDF(Request $request, $id)
    {
        $request->validate([
            'assunto_id'    => 'required|exists:assuntos,id',
            'texto_escrito' => 'required',
        ]);

        // 1. Procurar o processo com as relações
        $processo = Processos::with(['tecnica', 'estado', 'aditamentos'])->findOrFail($id);
        $assuntoModel = Assuntos::findOrFail($request->assunto_id);

        // 2. Registar o encerramento no histórico de aditamentos
        $processo->aditamentos()->create([
            'processo_id'           => $processo->id,
            'tecnica_id'            => $processo->tecnica_id,
            'data_registo'          => now(),
            'estado_inicial'        => $processo->estado->nome ?? 'em Apreciação',
            'estado_atual'          => 'Concluído',
            'historico_aditamentos' => 'Ofício gerado automaticamente. O processo foi dado como finalizado.',
            'descricao'             => 'Emissão de Despacho/Ofício: ' . $assuntoModel->titulo,
        ]);

        // 3. Atualizar o estado principal para Concluído (ID 3)
        $processo->update(['estado_id' => 3]);

        // 4. Preparar dados para o PDF
        $data = [
            'processo'             => $processo,
            'data_atual'           => Carbon::now()->format('d/m/Y'),
            'assunto_titulo'       => $assuntoModel->titulo,
            'assunto_texto_padrao' => $assuntoModel->texto_padrao,
            'texto_caixa_detalhes' => $request->texto_escrito,
            'materiais'            => $request->materiais_texto,
            'id_aditamento'        => $processo->aditamentos->last()->id // Pega o ID do aditamento acabado de criar
        ];

        // 5. Gerar e devolver o PDF para o browser
        $pdf = Pdf::loadView('pdf.oficio', $data);
        return $pdf->stream('Oficio_' . $processo->numero_eamb . '.pdf');
    }
}
