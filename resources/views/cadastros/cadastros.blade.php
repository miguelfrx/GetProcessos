<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros GetProcessos</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@include('partials.header')

<body class="bg-gray-100">
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
    <div class="relative overflow-x-auto bg-white shadow rounded border border-gray-200">

        <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ url('/todos-cadastros') }}" class="flex gap-2 items-center flex-wrap">
                <input type="text" name="search" placeholder="Pesquisar por nome ou email"
                    value="{{ request('search') }}"
                    class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" />

                <select name="estado" class="px-3 py-2 border border-gray-300 rounded">
                    <option value="">Todos os estados</option>
                    <option value="verde" {{ request('estado')=='verde' ? 'selected' : '' }}>Verde</option>
                    <option value="amarelo" {{ request('estado')=='amarelo' ? 'selected' : '' }}>Amarelo</option>
                    <option value="vermelho" {{ request('estado')=='vermelho' ? 'selected' : '' }}>Vermelho</option>
                    <option value="a tratar" {{ request('estado')=='a tratar' ? 'selected' : '' }}>A Tratar</option>
                </select>

                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Filtrar
                </button>
            </form>
        </div>

        <table class="w-full text-left text-sm text-gray-700">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-4 py-2">Num</th>
                    <th class="px-4 py-2">Nome</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Anexos</th>
                </tr>
            </thead>

            <tbody>
                @forelse($cadastros as $cadastro)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $loop->iteration }}</td>

                    <td class="px-4 py-2">
                        <a href="{{ route('cadastros.show', $cadastro->id) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $cadastro->nome }}
                        </a>
                    </td>

                    <td class="px-4 py-2">{{ $cadastro->email }}</td>

                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-white font-semibold 
                            @if($cadastro->estado=='verde') bg-green-500 
                            @elseif($cadastro->estado=='amarelo') bg-yellow-500 
                            @elseif($cadastro->estado=='vermelho') bg-red-500 
                            @elseif($cadastro->estado=='a tratar') bg-blue-500 
                            @else bg-gray-400 @endif">
                            {{ $cadastro->estado }}
                        </span>
                    </td>

                    <td class="px-4 py-2">{{ $cadastro->anexos ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">Nenhum cadastro encontrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('partials.footer')
</body>
</html>
