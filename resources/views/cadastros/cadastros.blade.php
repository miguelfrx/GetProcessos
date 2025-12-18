<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastros GetProcessos</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Animação suave do alerta --}}
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>

@include('partials.header')

<body class="bg-gray-100">

    {{-- BACKGROUND --}}
    <div class="fixed inset-0 -z-10">
        <img 
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            class="w-full h-full object-cover"
            alt="Background"
        >
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>

    @include('partials.sidebar')

    {{-- CONTEÚDO --}}
    <div class="p-4 sm:ml-64 mt-20">
        <div class="relative overflow-x-auto bg-white shadow rounded border border-gray-200">

            {{-- FILTROS --}}
            <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <form method="GET" action="{{ url('/todos-cadastros') }}" class="flex gap-2 items-center flex-wrap">
                    <input type="text" name="search" placeholder="Pesquisar por nome ou email"
                        value="{{ request('search') }}"
                        class="px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" />

                    <select name="estado" class="px-3 py-2 border border-gray-300 rounded">
                        <option value="">Todos os estados</option>
                        <option value="Submetido" {{ request('estado')=='Submetido' ? 'selected' : '' }}>Submetido</option>
                        <option value="Para Correção" {{ request('estado')=='Para Correção' ? 'selected' : '' }}>Para Correção</option>
                        <option value="Aguardar Pagamento" {{ request('estado')=='Aguardar Pagamento' ? 'selected' : '' }}>Aguardar Pagamento</option>
                        <option value="Pagamento Efetuado" {{ request('estado')=='Pagamento Efetuado' ? 'selected' : '' }}>Pagamento Efetuado</option>
                        <option value="Concluído" {{ request('estado')=='Concluído' ? 'selected' : '' }}>Concluído</option>
                    </select>

                    <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Filtrar
                    </button>
                </form>
            </div>

            {{-- TABELA --}}
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
                                @php
                                    $estadoClasses = [
                                        'Submetido' => 'bg-blue-500 text-white text-xs font-medium px-1.5 py-0.5 rounded',
                                        'Para Correção' => 'bg-yellow-400 text-black text-xs font-medium px-1.5 py-0.5 rounded',
                                        'Aguardar Pagamento' => 'bg-pink-500 text-white text-xs font-medium px-1.5 py-0.5 rounded',
                                        'Pagamento Efectuado' => 'bg-green-500 text-white text-xs font-medium px-1.5 py-0.5 rounded',
                                        'Concluído' => 'bg-gray-700 text-white text-xs font-medium px-1.5 py-0.5 rounded',
                                    ];
                                    $classe = $estadoClasses[$cadastro->estado->descricao] ?? 'bg-gray-400 text-white text-xs font-medium px-1.5 py-0.5 rounded';
                                @endphp

                                <span class="{{ $classe }}">
                                    {{ $cadastro->estado->descricao }}
                                </span>
                            </td>

                            <td class="px-4 py-2">
                                {{ $cadastro->anexos->count() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                Nenhum cadastro encontrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ALERTA DE SUCESSO (FUNDO DA PÁGINA) --}}
    @if(session('success'))
        <div 
            id="success-alert"
            class="fixed bottom-6 right-6 z-50 flex items-start gap-3 max-w-sm p-4
                   text-sm text-green-900 bg-green-100 border border-green-300
                   rounded-xl shadow-lg animate-fade-in"
            role="alert"
        >
            <div class="flex-1">
                <span class="font-semibold block">Sucesso</span>
                <span>{{ session('success') }}</span>
            </div>

            <button 
                onclick="document.getElementById('success-alert').remove()"
                class="text-green-700 hover:text-green-900 font-bold text-lg leading-none"
            >
                ×
            </button>
        </div>

        <script>
            setTimeout(() => {
                const alert = document.getElementById('success-alert');
                if (alert) {
                    alert.classList.add('opacity-0');
                    setTimeout(() => alert.remove(), 300);
                }
            }, 6000);
        </script>
    @endif

    @include('partials.footer')

</body>
</html>
