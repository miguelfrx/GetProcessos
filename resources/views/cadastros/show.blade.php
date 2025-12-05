<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Utilizador</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@include('partials.header')

<body class="bg-gray-100 font-sans">
    <div class="fixed inset-0 -z-10">
        <img 
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            class="w-full h-full object-cover"
            alt="Background"
        >
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>

@include('partials.sidebar')

<div class="p-4 sm:ml-64 mt-20">

    <!-- Card Principal -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Detalhes do Utilizador</h1>

        {{-- Mensagem de sucesso --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Erros de validação --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulário de edição -->
        <form action="{{ route('atualizar.cadastro', $cadastro->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Nome -->
                <div>
                    <label class="block text-gray-500 font-semibold mb-1">Nome</label>
                    <input type="text" name="nome" value="{{ $cadastro->nome }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-gray-500 font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ $cadastro->email }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                </div>

                <!-- Contacto -->
                <div>
                    <label class="block text-gray-500 font-semibold mb-1">Contacto</label>
                    <input type="text" name="contacto" value="{{ $cadastro->contacto }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <!-- Responsável -->
                <div>
                    <label class="block text-gray-500 font-semibold mb-1">Responsável</label>
                    <input type="text" name="responsavel" value="{{ $cadastro->responsavel }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <!-- Estado -->
                <div>
                    <label class="block text-gray-500 font-semibold mb-1">Estado</label>
                    <select name="estado" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300" required>
                        <option value="verde" {{ $cadastro->estado=='verde' ? 'selected' : '' }}>Verde</option>
                        <option value="amarelo" {{ $cadastro->estado=='amarelo' ? 'selected' : '' }}>Amarelo</option>
                        <option value="vermelho" {{ $cadastro->estado=='vermelho' ? 'selected' : '' }}>Vermelho</option>
                        <option value="a tratar" {{ $cadastro->estado=='a tratar' ? 'selected' : '' }}>A tratar</option>
                    </select>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('todos.cadastros') }}" class="px-4 py-2 rounded bg-gray-300 text-gray-800 hover:bg-gray-400">
                    Cancelar
                </a>

                <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
                    Atualizar Cadastro
                </button>
            </div>
        </form>
    </div>

</div>

</body>
</html>
