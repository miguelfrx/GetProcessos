@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Criar Cadastro</h1>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="bg-green-500 text-white p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    {{-- Erros de validação --}}
    @if($errors->any())
        <div class="bg-red-500 text-white p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cadastros.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        {{-- Nome --}}
        <div>
            <label class="block font-semibold mb-1">Nome</label>
            <input type="text" name="nome" class="border p-2 w-full" required>
        </div>

        {{-- Email --}}
        <div>
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" name="email" class="border p-2 w-full" required>
        </div>

        {{-- Contacto --}}
        <div>
            <label class="block font-semibold mb-1">Contacto</label>
            <input type="number" name="contato" class="border p-2 w-full" required>
        </div>

        {{-- Estado --}}
        <div>
            <label class="block font-semibold mb-1">Estado</label>
            <select name="estado_id" class="border p-2 w-full" required>
                <option value="">-- Selecionar Estado --</option>
                @foreach($estados as $estado)
                    <option value="{{ $estado->id }}">{{ $estado->descricao }}</option>
                @endforeach
            </select>
        </div>

        {{-- Num Cadastro --}}
        <div>
            <label class="block font-semibold mb-1">Num Cadastro</label>
            <input type="text" name="numcadastro" class="border p-2 w-full" required>
        </div>

        {{-- Anexos --}}
        <div>
            <label class="block font-semibold mb-1">Anexos</label>
            <input type="file" name="anexos[]" multiple class="border p-2 w-full">
        </div>

        {{-- Botão --}}
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Criar Cadastro
        </button>
    </form>
</div>
@endsection
