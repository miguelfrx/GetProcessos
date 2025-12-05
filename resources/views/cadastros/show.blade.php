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

        <!-- Grid de Informações -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Nome -->
            <div>
                <h2 class="text-gray-500 font-semibold">Nome</h2>
                <p class="text-gray-800 text-lg font-medium">{{ $cadastro->nome }}</p>
            </div>

            <!-- Email -->
            <div>
                <h2 class="text-gray-500 font-semibold">Email</h2>
                <p class="text-gray-800 text-lg font-medium">{{ $cadastro->email }}</p>
            </div>

            <!-- Contacto -->
            <div>
                <h2 class="text-gray-500 font-semibold">Contacto</h2>
                <p class="text-gray-800 text-lg font-medium">{{ $cadastro->contacto ?? '-' }}</p>
            </div>

            <!-- Estado Atual -->
            <div>
                <h2 class="text-gray-500 font-semibold">Estado Atual</h2>
                <span class="px-3 py-1 rounded-full text-white font-semibold 
                    @if($cadastro->estado=='verde') bg-green-500 
                    @elseif($cadastro->estado=='amarelo') bg-yellow-500 
                    @elseif($cadastro->estado=='vermelho') bg-red-500 
                    @elseif($cadastro->estado=='a tratar') bg-blue-500 
                    @else bg-gray-400 @endif">
                    {{ $cadastro->estado }}
                </span>
            </div>

            <!-- Data de Entrada -->
            <div>
                <h2 class="text-gray-500 font-semibold">Data de Entrada</h2>
                <p class="text-gray-800 text-lg font-medium">{{ $cadastro->created_at ?? '-' }}</p>
            </div>

            <!-- Anexos -->
            <div>
                <h2 class="text-gray-500 font-semibold">Anexos</h2>
                @if($cadastro->anexos)
                    <ul class="list-disc list-inside text-blue-600">
                        @foreach(explode(',', $cadastro->anexos) as $anexo)
                            <li><a href="{{ asset('storage/' . trim($anexo)) }}" target="_blank" class="hover:underline">{{ trim($anexo) }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-800">-</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Tabela de Estado Atual -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Tabela de Estado Atual</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Estado</th>
                    <th class="px-4 py-2 border">Atualizado em</th>
                    <th class="px-4 py-2 border">Responsável</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 rounded-full text-white font-semibold
                        @if($cadastro->estado=='verde') bg-green-500
                        @elseif($cadastro->estado=='amarelo') bg-yellow-500
                        @elseif($cadastro->estado=='vermelho') bg-red-500
                        @elseif($cadastro->estado=='a tratar') bg-blue-500
                        @else bg-gray-400 @endif">
                        {{ $cadastro->estado }}</span>
                    </td>
                    <td class="px-4 py-2 border">{{ $cadastro->updated_at ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $cadastro->responsavel ?? '-' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Histórico de Estados -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 border border-gray-200">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Histórico de Estados</h2>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 border">Estado</th>
                    <th class="px-4 py-2 border">Data</th>
                    <th class="px-4 py-2 border">Responsável</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($historicoEstados) && count($historicoEstados) > 0)
                    @foreach($historicoEstados as $h)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">
                                <span class="px-2 py-1 rounded-full text-white font-semibold
                                @if($h->estado=='verde') bg-green-500
                                @elseif($h->estado=='amarelo') bg-yellow-500
                                @elseif($h->estado=='vermelho') bg-red-500
                                @elseif($h->estado=='a tratar') bg-blue-500
                                @else bg-gray-400 @endif">
                                {{ $h->estado }}</span>
                            </td>
                            <td class="px-4 py-2 border">{{ $h->created_at }}</td>
                            <td class="px-4 py-2 border">{{ $h->responsavel }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="px-4 py-2 text-center text-gray-500">Sem histórico</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <a href="{{ route('todos.cadastros') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        ← Voltar
    </a>

</div>

</body>
</html>
