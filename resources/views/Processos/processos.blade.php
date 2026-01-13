<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Gestão de Processos - EAmb</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

@include('partials.header')

<body class="bg-gray-100">

    {{-- Background --}}
    <div class="fixed inset-0 -z-10">
        <img
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            class="w-full h-full object-cover"
            alt="Background">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>

    @include('partials.sidebar')

    <div class="p-4 sm:ml-64 mt-20">

        <div class="bg-white shadow-xl rounded-lg border border-gray-200 overflow-hidden">

            {{-- Header --}}
            <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    Processos — Esposende Ambiente
                </h2>

                {{-- Filtros --}}
                <form method="GET" action="{{ route('processos.index') }}" class="flex flex-wrap gap-3">

                    <input
                        type="text"
                        name="search"
                        placeholder="Nº EAmb, Requerente ou CME..."
                        value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-lg w-full sm:w-80 focus:ring-2 focus:ring-blue-500 outline-none">

                    <select
                        name="estado"
                        class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                        <option value="">Todos os Estados</option>
                        @foreach($estados as $estado)
                        <option value="{{ $estado->id }}" {{ request('estado') == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nome }}
                        </option>
                        @endforeach
                    </select>

                    <button
                        type="submit"
                        class="px-6 py-2 bg-blue-700 text-white rounded-lg font-semibold hover:bg-blue-800 transition">
                        Filtrar
                    </button>

                </form>
            </div>

            {{-- Tabela --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-700">

                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                        <tr>
                            <th class="px-6 py-4">Ref. EAmb / CME</th>
                            <th class="px-6 py-4">Requerente</th>
                            <th class="px-6 py-4">Data Entrada</th>
                            <th class="px-6 py-4">Técnica Responsável</th>
                            <th class="px-6 py-4">Estado</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($processos as $processo)

                        <tr class="hover:bg-blue-50/50 transition">

                            {{-- Referências --}}
                            <td class="px-6 py-4">
                                <a href="{{ route('processos.show', $processo->id) }}" class="group">
                                    <div class="font-bold text-blue-900 group-hover:underline">
                                        {{ $processo->numero_eamb }}
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        {{ $processo->numero_cme ?? 'Sem ref. CME' }}
                                    </div>
                                </a>
                            </td>

                            {{-- Requerente --}}
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $processo->requerente }}
                            </td>

                            {{-- Data --}}
                            <td class="px-6 py-4 text-gray-500">
                                {{ $processo->data_entrada
                                        ? \Carbon\Carbon::parse($processo->data_entrada)->format('d/m/Y')
                                        : 'n/a'
                                    }}
                            </td>

                            {{-- Técnica --}}
                            <td class="px-6 py-4 text-gray-600">
                                {{ $processo->tecnica->nome ?? 'Não atribuída' }}
                            </td>

                            {{-- Estado (SEM ERRO CSS) --}}
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                                    @style([ 'background-color'=> $processo->estado->cor ?? '#6b7280'
                                    ])
                                    >
                                    {{ $processo->estado->nome ?? 'Desconhecido' }}
                                </span>
                            </td>

                            {{-- Ações --}}
                            <td class="px-6 py-4 text-right">
                                <a
                                    href="{{ route('processos.show', $processo->id) }}"
                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white rounded-md text-xs hover:bg-blue-700">
                                    Abrir Detalhes
                                </a>
                            </td>

                        </tr>

                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                Nenhum processo encontrado.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @include('partials.footer')

</body>

</html>