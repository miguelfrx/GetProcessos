@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Gerar Novo Ofício</h1>

    <form action="{{ route('oficios.generate') }}" method="POST" target="_blank" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block mb-2">Selecione o Processo:</label>
            <select name="processo_id" class="w-full border rounded p-2" required>
                @foreach($processos as $p)
                <option value="{{ $p->id }}">{{ $p->numero_processo }} - {{ $p->requerente }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-2">Assunto:</label>
            <input type="text" name="assunto" class="w-full border rounded p-2" required placeholder="Ex: Pedido de Elementos">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Conteúdo / Descrição:</label>
            <textarea name="conteudo" rows="5" class="w-full border rounded p-2" required></textarea>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Gerar PDF
        </button>
    </form>
</div>
@endsection