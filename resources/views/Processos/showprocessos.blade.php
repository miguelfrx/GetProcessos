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
                <h1 class="text-2xl font-black uppercase italic">Análise de Processo</h1>
                <div class="flex gap-4">
                    <span class="px-4 py-1 rounded-full text-sm font-bold bg-blue-600 shadow-lg">ID Processo: {{ $processo->id }}</span>
                    <span class="px-4 py-1 rounded-full text-sm font-bold bg-green-600 shadow-lg">Aditamento: {{ $processo->aditamentos->last()->id ?? 'Novo' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">

                    {{-- DADOS DO REQUERENTE --}}
                    <div class="bg-white/95 backdrop-blur shadow-xl rounded-xl border p-6">
                        <h3 class="text-xs font-black text-blue-800 uppercase mb-4 border-b pb-2">Dados Completos do Requerente</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-6 text-sm">
                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">Nº EAmb</label>
                                <p class="font-bold text-lg">{{ $processo->numero_eamb }}</p>
                            </div>
                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">Nº CME</label>
                                <p class="font-bold text-lg text-blue-600">{{ $processo->numero_cme ?? 'N/A' }}</p>
                            </div>
                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">Data Entrada</label>
                                <p class="font-bold">{{ $processo->data_entrada }}</p>
                            </div>

                            <div class="col-span-2"><label class="block text-[10px] text-gray-400 font-bold uppercase">Nome do Requerente</label>
                                <p class="font-bold text-gray-800">{{ $processo->requerente }}</p>
                            </div>
                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">NIF</label>
                                <p class="font-bold">{{ $processo->nif }}</p>
                            </div>

                            <div class="col-span-3 border-t pt-2"><label class="block text-[10px] text-gray-400 font-bold uppercase">Morada Completa</label>
                                <p class="font-medium text-gray-700">{{ $processo->morada_localizacao }}</p>
                            </div>

                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">Freguesia</label>
                                <p class="font-medium">{{ $processo->freguesia }}</p>
                            </div>
                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">Telefone</label>
                                <p class="font-medium">{{ $processo->telefone }}</p>
                            </div>
                            <div><label class="block text-[10px] text-gray-400 font-bold uppercase">Email</label>
                                <p class="font-medium text-blue-500">{{ $processo->email }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- HISTÓRICO --}}
                    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                        <div class="bg-slate-800 px-6 py-3 text-white">
                            <span class="font-bold uppercase text-xs tracking-widest">Histórico de Apreciação</span>
                        </div>
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 text-[10px] font-black uppercase text-gray-400">
                                <tr>
                                    <th class="px-6 py-3">Descrição técnica</th>
                                    <th class="px-6 py-3">Data</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($processo->aditamentos as $ad)
                                <tr>
                                    <td class="px-6 py-4 text-gray-700">{{ $ad->descricao }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $ad->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- FORMULÁRIO DO DESPACHO (PDF) --}}
                <div class="bg-slate-900 p-6 rounded-xl shadow-2xl border border-slate-700 text-white">
                    <h3 class="text-red-500 font-black text-xs uppercase mb-6 border-b border-slate-800 pb-2">Configurar Despacho Automático</h3>

                    <form action="{{ route('processos.pdf', $processo->id) }}" method="POST" target="_blank" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">1. Assunto do Ofício</label>
                            <select name="assunto_id" required class="w-full bg-slate-800 border-slate-700 rounded-lg text-sm p-3 focus:ring-2 focus:ring-red-500 text-white">
                                <option value="">Escolher assunto...</option>
                                @foreach(\App\Models\Assuntos::all() as $assunto)
                                {{-- Aqui usamos o campo 'titulo' para mostrar ao utilizador --}}
                                <option value="{{ $assunto->id }}">
                                    {{ $assunto->titulo }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">2. Materiais Utilizados (Texto Livre)</label>
                            <textarea name="materiais_texto" rows="3" class="w-full bg-slate-800 border-slate-700 rounded-lg text-sm p-3 focus:ring-2 focus:ring-red-500"
                                placeholder="Ex: 2 tubos de 110mm, 1 curva de 90º..."></textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">3. Descrição do Parecer</label>
                            <textarea name="texto_escrito" rows="6" required class="w-full bg-slate-800 border-slate-700 rounded-lg text-sm p-3 focus:ring-2 focus:ring-red-500"
                                placeholder="Escreva o corpo do despacho aqui..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-red-600 py-4 rounded-xl font-black text-xs uppercase tracking-tighter hover:bg-red-700 transition-all shadow-lg active:scale-95">
                            Gerar PDF com Dados Automáticos
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>