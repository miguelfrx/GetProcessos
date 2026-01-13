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
        $processo = Processos::with(['estado', 'tecnica', 'aditamentos.tecnica'])->findOrFail($id);
        return view('Processos.showprocessos', compact('processo'));
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
        // 1. Validar os dados que vêm do formulário
        $request->validate([
            'assunto_id'    => 'required|exists:assuntos,id',
            'texto_escrito' => 'required',
        ]);

        // 2. Procurar o processo
        $processo = Processos::with(['tecnica', 'aditamentos'])->findOrFail($id);

        // 3. DEFINIR A VARIÁVEL QUE ESTÁ A DAR ERRO
        // Procuramos o assunto na tabela para extrair o campo 'titulo'
        $assuntoModel = Assuntos::findOrFail($request->assunto_id);

        // 4. Montar o array de dados para o PDF
        $data = [
            'processo'           => $processo,
            'data_atual'         => \Carbon\Carbon::now()->format('d/m/Y'),
            'assunto_selecionado' => $assuntoModel->titulo, // Aqui usamos a variável definida acima
            'texto_corpo'        => $request->texto_escrito,
            'materiais'          => $request->materiais_texto,
            'id_aditamento'      => $processo->aditamentos->last()->id ?? 'N/A'
        ];

        // 5. Gerar e retornar o PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.oficio', $data);
        return $pdf->stream('Oficio_' . $processo->numero_eamb . '.pdf');
    }
}
