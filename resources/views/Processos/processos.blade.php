<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Processos - EAmb</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    @include('partials.header')

    {{-- Background Dinâmico (Igual ao Show) --}}
    <div class="fixed inset-0 -z-10">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            class="w-full h-full object-cover" alt="Background">
        <div class="absolute inset-0 bg-slate-900/70 backdrop-blur-sm"></div>
    </div>

    @include('partials.sidebar')

    <main class="p-4 sm:ml-64 mt-20 flex-grow">
        <div class="max-w-7xl mx-auto">

            {{-- Cabeçalho da Página --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tighter italic">
                        Gestão de <span class="text-blue-400">Processos</span>
                    </h1>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Esposende Ambiente, E.E.M.</p>
                </div>

                {{-- Barra de Pesquisa Moderna --}}
                <form action="{{ route('processos.index') }}" method="GET" class="flex w-full md:w-auto group">
                    <div class="relative w-full md:w-96">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Pesquisar Nº EAmb, CME ou Requerente..."
                            class="w-full pl-4 pr-12 py-3 bg-white/10 border border-white/20 rounded-l-xl text-white text-sm focus:ring-2 focus:ring-blue-500 outline-none backdrop-blur-md transition-all placeholder:text-gray-500">
                        <div class="absolute right-3 top-3 text-gray-500 group-focus-within:text-blue-400 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-r-xl transition-all font-black text-xs uppercase shadow-lg active:scale-95">
                        Filtrar
                    </button>
                </form>
            </div>

            {{-- Content Card --}}
            <div class="bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl border border-white/20 overflow-hidden">

                {{-- Toolbar Superior --}}
                <div class="bg-gray-50/50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-6 bg-blue-600 rounded-full"></div>
                        <h2 class="text-xs font-black uppercase text-gray-500 tracking-widest">
                            Registos em Sistema
                        </h2>
                    </div>
                    <span class="text-[10px] font-bold bg-gray-200 text-gray-600 px-2 py-1 rounded uppercase">
                        Total: {{ $processos->total() }}
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="text-[10px] text-gray-400 uppercase font-black tracking-widest border-b bg-gray-50/50">
                                <th class="px-6 py-4">Referência EAmb</th>
                                <th class="px-6 py-4">Identificação do Requerente</th>
                                <th class="px-6 py-4 text-center">Estado Atual</th>
                                <th class="px-6 py-4">Técnico/a Designado</th>
                                <th class="px-6 py-4 text-right">Gestão</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($processos as $p)
                            <tr class="hover:bg-blue-50/40 transition-all group">

                                {{-- Nº EAmb --}}
                                <td class="px-6 py-4">
                                    <div class="text-blue-700 font-black text-base tracking-tighter">
                                        {{ $p->numero_eamb }}
                                    </div>
                                    <div class="text-[9px] font-bold text-gray-400 uppercase">Ref. Interna</div>
                                </td>

                                {{-- Requerente --}}
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800 group-hover:text-blue-900 transition-colors">
                                        {{ $p->requerente }}
                                    </div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded font-mono uppercase">
                                            CME: {{ $p->numero_cme ?? 'Pendente' }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Estado --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1.5 rounded-lg text-[10px] font-black text-white uppercase shadow-sm inline-block min-w-[120px]"
                                        @style(['background-color'=> $p->estado->cor ?? '#6b7280'])>
                                        {{ $p->estado->nome ?? 'Pendente' }}
                                    </span>
                                </td>

                                {{-- Técnica --}}
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-800 flex items-center justify-center text-xs font-black text-blue-400 border border-slate-700 shadow-inner">
                                            {{ strtoupper(substr($p->tecnica->nome ?? '?', 0, 1)) }}
                                        </div>
                                        <div class="text-left">
                                            <p class="text-xs font-bold text-gray-700 leading-tight">{{ $p->tecnica->nome ?? 'Não atribuído' }}</p>
                                            <p class="text-[9px] text-gray-400 font-bold uppercase">Responsável</p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Ações --}}
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('processos.show', $p->id) }}"
                                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-[10px] font-black uppercase transition-all shadow-md active:scale-95 group-hover:shadow-blue-200">
                                        <span>Analisar</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-gray-400 font-bold uppercase text-xs tracking-widest">Nenhum processo encontrado em sistema.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Paginação Estilizada --}}
                <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-100">
                    {{ $processos->links() }}
                </div>

            </div>
        </div>
    </main>

    @include('partials.footer')

</body>

</html>