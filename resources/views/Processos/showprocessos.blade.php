<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Processo - {{ $processo->numero_eamb }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    @include('partials.header')
    @include('partials.sidebar')

    <div class="p-4 sm:ml-64 mt-20">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Processo: {{ $processo->numero_eamb }}</h1>
            <a href="{{ route('processos.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Voltar à Lista
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white shadow rounded-lg overflow-hidden border">
                    <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                        <span class="text-sm font-bold uppercase text-gray-600">Dados do Requerente</span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold text-white uppercase"
                            style="--bg-color: {{ $processo->estado->cor ?? '#6b7280' }}; background-color: var(--bg-color);">
                            {{ $processo->estado->nome }}
                        </span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                        <div>
                            <label class="text-xs text-gray-400 uppercase">Nome do Requerente</label>
                            <p class="font-semibold text-gray-800">{{ $processo->requerente }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 uppercase">NIF</label>
                            <p class="font-semibold text-gray-800">{{ $processo->nif ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 uppercase">Ref. Câmara (CME)</label>
                            <p class="text-gray-700 font-medium">{{ $processo->numero_cme ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-400 uppercase">Data de Entrada</label>
                            <p class="text-gray-700 font-medium">{{ $processo->data_entrada ? date('d/m/Y', strtotime($processo->data_entrada)) : '---' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs text-gray-400 uppercase">Localização / Morada</label>
                            <p class="text-gray-700 font-medium">{{ $processo->morada_localizacao ?? 'Não especificada' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg border">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <span class="text-sm font-bold uppercase text-gray-600">Histórico de Aditamentos</span>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @forelse($processo->aditamentos as $adit)
                            <div class="relative pl-8 border-l-2 border-blue-500">
                                <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-blue-500 border-2 border-white"></div>
                                <div class="mb-1 flex justify-between items-center">
                                    <span class="text-sm font-bold text-gray-900">{{ $adit->tecnica->nome ?? 'Técnica' }}</span>
                                    <span class="text-xs text-gray-400">{{ $adit->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="text-sm text-gray-600 bg-gray-50 p-3 rounded border">
                                    {{ $adit->descricao }}
                                </div>
                                <div class="mt-1 text-[10px] font-bold text-blue-600 uppercase">
                                    Estado após aditamento: {{ $adit->estado_atual }}
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4 text-gray-400 italic">
                                Nenhum aditamento registado. Aguarda início de apreciação.
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">

                <div class="bg-blue-800 rounded-lg shadow p-6 text-white">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-blue-300 mb-4">Técnica Responsável</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-xl font-bold border-2 border-blue-400">
                            {{ substr($processo->tecnica->nome ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-lg font-bold">{{ $processo->tecnica->nome ?? 'Pendente' }}</p>
                            <p class="text-xs opacity-75 italic">EAmb - Esposende Ambiente</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg border p-6">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Iniciar Apreciação</h3>

                    <form action="{{ route('aditamentos.store', $processo->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Observações / Descrição</label>
                            <textarea name="descricao" rows="5" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 text-sm outline-none"
                                placeholder="Descreva aqui o estado das peças ou as primeiras impressões técnicas..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 rounded-lg shadow-md transition duration-200">
                            Registar Aditamento
                        </button>

                        <p class="mt-4 text-[10px] text-gray-400 text-center uppercase leading-tight">
                            Ao registar, o estado passará para <strong>Em Apreciação</strong>.
                        </p>
                    </form>
                </div>

                <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-lg p-6 text-center">
                    <p class="text-xs text-gray-400 uppercase font-bold italic">Espaço para Geração de Despacho/PDF</p>
                </div>

            </div>
        </div>
    </div>

    @include('partials.footer')

</body>

</html>