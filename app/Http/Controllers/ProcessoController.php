<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Processos;
use App\Models\EstadoProcesso;
use App\Models\Assuntos; // Certifica-te que o model é Assuntos ou Assunto
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ProcessoController extends Controller
{
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

    public function show($id)
    {
        // Puxamos também os assuntos para a dropdown na vista de detalhes
        $processo = Processos::with(['estado', 'tecnica', 'aditamentos.tecnica'])->findOrFail($id);
        $assuntos = Assuntos::all();

        return view('Processos.showprocessos', compact('processo', 'assuntos'));
    }

    public function storeAditamento(Request $request, $id)
    {
        $processo = Processos::findOrFail($id);

        $processo->aditamentos()->create([
            'tecnica_id'   => $processo->tecnica_id,
            'descricao'    => $request->descricao,
            'estado_atual' => 'em Apreciação'
        ]);

        $processo->update(['estado_id' => 2]);

        return redirect()->back()->with('success', 'Análise registada!');
    }

    public function generatePDF(Request $request, $id)
    {
        // 1. Validar os dados
        $request->validate([
            'assunto_id'    => 'required|exists:assuntos,id',
            'texto_escrito' => 'required', // A tua caixa de texto (parecer)
        ]);

        // 2. Procurar o processo com relações
        $processo = Processos::with(['tecnica', 'aditamentos'])->findOrFail($id);

        // 3. Procurar o assunto para extrair o Título e o Texto Padrão (Leis/Normas)
        $assuntoModel = Assuntos::findOrFail($request->assunto_id);

        // 4. Montar o array de dados (Nomes das chaves ajustados para o PDF)
        $data = [
            'processo'             => $processo,
            'data_atual'           => Carbon::now()->format('d/m/Y'),

            // Dados da Tabela Assuntos
            'assunto_titulo'       => $assuntoModel->titulo,
            'assunto_texto_padrao' => $assuntoModel->texto_padrao,

            // Dados do Formulário (O que o técnico preencheu)
            'texto_caixa_detalhes' => $request->texto_escrito,   // O Parecer
            'materiais'            => $request->materiais_texto, // Os Materiais

            'id_aditamento'        => $processo->aditamentos->last()->id ?? 'N/A'
        ];

        // 5. Gerar e retornar o PDF
        $pdf = Pdf::loadView('pdf.oficio', $data);

        return $pdf->stream('Oficio_' . $processo->numero_eamb . '.pdf');
    }
}
