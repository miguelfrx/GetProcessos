<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Processo {{ $processo->numero_eamb }} - EAmb</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @include('partials.header')

    <div class="fixed inset-0 -z-10">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-slate-900/60"></div>
    </div>

    @include('partials.sidebar')

    <main class="p-4 sm:ml-64 mt-20">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="flex justify-between items-center text-white">
                <div class="space-y-1">
                    <h1 class="text-2xl font-black uppercase italic">Análise de Processo</h1>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Gestão Interna Esposende Ambiente</p>
                </div>
                <div class="flex gap-4">
                    <span class="px-4 py-1 rounded-full text-sm font-bold bg-blue-600 shadow-lg border border-blue-400">ID Processo: {{ $processo->id }}</span>
                    <span class="px-4 py-1 rounded-full text-sm font-bold bg-green-600 shadow-lg border border-green-400">Aditamento: {{ $processo->aditamentos->last()->id ?? 'Novo' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white/95 backdrop-blur shadow-xl rounded-xl border p-6">
                        <h3 class="text-xs font-black text-blue-800 uppercase mb-4 border-b pb-2">Dados do Requerente</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">
                            <div>
                                <label class="block text-[10px] text-gray-400 font-bold uppercase">Nº EAmb</label>
                                <p class="font-bold text-lg">{{ $processo->numero_eamb }}</p>
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-400 font-bold uppercase">Nº CME</label>
                                <p class="font-bold text-lg text-blue-600">{{ $processo->numero_cme ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-400 font-bold uppercase">Data Entrada</label>
                                <p class="font-bold">{{ \Carbon\Carbon::parse($processo->data_entrada)->format('d/m/Y') }}</p>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-[10px] text-gray-400 font-bold uppercase">Requerente</label>
                                <p class="font-bold text-gray-800">{{ $processo->requerente }}</p>
                            </div>
                            <div>
                                <label class="block text-[10px] text-gray-400 font-bold uppercase">NIF</label>
                                <p class="font-bold">{{ $processo->nif }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
                        <div class="bg-slate-800 px-6 py-3 text-white flex justify-between items-center">
                            <span class="font-bold uppercase text-xs tracking-widest">Histórico de Aditamentos / Estados</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-[10px] font-black uppercase text-gray-400 border-b">
                                    <tr>
                                        <th class="px-6 py-3">ID</th>
                                        <th class="px-6 py-3">Data Registo</th>
                                        <th class="px-6 py-3">Estado Atual</th>
                                        <th class="px-6 py-3">Descrição Técnica</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($processo->aditamentos as $ad)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <span class="text-[9px] text-gray-400 block uppercase font-bold">{{ $ad->estado_inicial }}</span>
                                            <span class="font-black text-blue-600 flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $ad->estado_atual }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-800">{{ $ad->descricao }}</p>
                                            <p class="text-xs text-gray-500 italic">{{ $ad->historico_aditamentos }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-gray-500 text-right font-medium">
                                            {{ $ad->created_at->format('d/m/Y') }}<br>
                                            <span class="text-[10px]">{{ $ad->created_at->format('H:i') }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-10 text-center text-gray-400 italic font-medium">
                                            Nenhum aditamento registado para este processo.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">

                    <div class="bg-slate-900 p-6 rounded-xl shadow-2xl border border-slate-700 text-white">
                        <h3 class="text-blue-500 font-black text-xs uppercase mb-4 border-b border-slate-800 pb-2 flex items-center gap-2">
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            Gestão de Estados
                        </h3>
                        <form action="{{ route('aditamentos.store', $processo->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="group w-full bg-blue-600 py-3 rounded-xl font-black text-xs uppercase hover:bg-blue-700 transition-all shadow-lg flex items-center justify-center gap-2 active:scale-95">
                                Gerar Novo Aditamento
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        </form>
                        <div class="mt-4 p-3 bg-slate-800/50 rounded-lg border border-slate-700">
                            <p class="text-[9px] text-slate-400 uppercase font-bold text-center">Fluxo Automático:</p>
                            <div class="flex items-center justify-between mt-1 px-2 text-[10px] font-bold">
                                <span class="text-gray-500 italic">Atual</span>
                                <span class="text-yellow-500">Validação</span>
                                <span class="text-green-500">Appreciation</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 p-6 rounded-xl shadow-2xl border border-slate-700 text-white">
                        <h3 class="text-red-500 font-black text-xs uppercase mb-6 border-b border-slate-800 pb-2 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            Despacho Automático
                        </h3>
                        <form action="{{ route('processos.pdf', $processo->id) }}" method="POST" target="_blank" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">1. Selecionar Assunto</label>
                                <select name="assunto_id" required class="w-full bg-slate-800 border-slate-700 rounded-lg text-sm p-3 text-white focus:ring-2 focus:ring-red-500 outline-none transition-all">
                                    <option value="">Escolher...</option>
                                    @foreach(\App\Models\Assuntos::all() as $assunto)
                                    <option value="{{ $assunto->id }}">{{ $assunto->titulo }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">2. Lista de Materiais</label>
                                <textarea name="materiais_texto" rows="2" class="w-full bg-slate-800 border-slate-700 rounded-lg text-sm p-3 text-white focus:ring-2 focus:ring-red-500 outline-none placeholder-slate-600" placeholder="Ex: Tubos PVC, Abraçadeiras..."></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">3. Corpo do Parecer</label>
                                <textarea name="texto_escrito" rows="5" required class="w-full bg-slate-800 border-slate-700 rounded-lg text-sm p-3 text-white focus:ring-2 focus:ring-red-500 outline-none placeholder-slate-600" placeholder="Detalhes técnicos da análise..."></textarea>
                            </div>
                            <button type="submit" class="w-full bg-red-600 py-4 rounded-xl font-black text-xs uppercase hover:bg-red-700 transition-all shadow-lg active:scale-95 flex items-center justify-center gap-2">
                                Gerar Documento PDF
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>