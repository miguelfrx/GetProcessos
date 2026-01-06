<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Processos - EAmb</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@include('partials.header')

<body class="bg-gray-100">

    <div class="fixed inset-0 -z-10">
        <img
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            class="w-full h-full object-cover"
            alt="Background">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>

    @include('partials.sidebar')

    <div class="p-4 sm:ml-64 mt-20">

        <div class="bg-white shadow rounded border border-gray-200 overflow-x-auto">

            <!-- FILTROS -->
            <div class="p-4 flex flex-col sm:flex-row gap-4 justify-between">
                <form method="GET" action="{{ route('processos.index') }}" class="flex flex-wrap gap-2">

                    <input type="text"
                        name="search"
                        placeholder="Pesquisar nº processo, requerente ou CME"
                        value="{{ request('search') }}"
                        class="px-3 py-2 border rounded w-64">

                    <select name="estado" class="px-3 py-2 border rounded">
                        <option value="">Todos os estados</option>
                        <option value="Em apreciação">Em apreciação</option>
                        <option value="A aguardar despacho">A aguardar despacho</option>
                        <option value="Despachado">Despachado</option>
                        <option value="Concluído">Concluído</option>
                    </select>

                    <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Filtrar
                    </button>
                </form>
            </div>

            <!-- TABELA -->
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2">Nº Processo</th>
                        <th class="px-4 py-2">Origem</th>
                        <th class="px-4 py-2">Requerente</th>
                        <th class="px-4 py-2">Técnica</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Aditamentos</th>
                        <th class="px-4 py-2 text-right">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($processos as $processo)
                    <tr class="border-b hover:bg-gray-50">

                        <td class="px-4 py-2 font-medium">
                            {{ $processo->numero_processo }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $processo->origem }} {{-- CME / Interno --}}
                        </td>

                        <td class="px-4 py-2">
                            {{ $processo->requerente }}
                        </td>

                        <td class="px-4 py-2">
                            {{ $processo->tecnica_nome ?? '—' }}
                        </td>

                        <td class="px-4 py-2">
                            <span class="px-2 py-1 text-xs rounded bg-blue-500 text-white">
                                {{ $processo->estado_descricao ?? 'Sem estado' }}
                            </span>
                        </td>

                        <td class="px-4 py-2 text-center">
                            {{ $processo->aditamentos_count ?? 0 }}
                        </td>

                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('processos.show', $processo->id) }}"
                                class="text-blue-600 hover:underline">
                                Abrir
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                            Nenhum processo encontrado.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    @include('partials.footer')

</body>

</html>