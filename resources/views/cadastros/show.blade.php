@extends('layouts.app')

@section('content')

{{-- Fundo igual ao da página principal --}}
<div class="fixed inset-0 -z-10">
    <img 
        src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
        class="w-full h-full object-cover"
        alt="Background"
    >
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
</div>

@include('partials.sidebar')
@include('partials.header')

<div class="p-4 sm:ml-64 mt-20">

    <div class="p-6 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-gray-200">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight">
                Detalhes do Cadastro
            </h2>

            <div class="flex gap-2">
                @if($cadastro->estado->descricao == 'Submetido')
                @if($estadoAguarda)
                <button 
                    data-modal-target="aguarda-modal" 
                    data-modal-toggle="aguarda-modal" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition"
                >
                    Aguarda Pagamento
                </button>
                @endif

                @if($estadoCorrecao)
                <button 
                    data-modal-target="correcao-modal" 
                    data-modal-toggle="correcao-modal" 
                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition"
                >
                    Para Correção
                </button>
                @endif
                @endif
            
            </div>
        </div>


       {{-- Estado Atual com Cores --}}
        @php
            $cores = [
                'Submetido' => 'azul',
                'Para Correção' => 'amarelo',
                'Aguardar Pagamento' => 'rosa',
                'Pagamento Efectuado' => 'verde'
            ];

            $estadoDescricao = $cadastro->estado->descricao ?? 'Desconhecido';
            $cor = $cores[$estadoDescricao] ?? 'cinzento';
        @endphp

<style>
    .estado-azul {
        background-color: #3498db;
        color: white;
    }
    .estado-amarelo {
        background-color: #f1c40f;
        color: black;
    }
    .estado-rosa {
        background-color: #ff66b2;
        color: white;
    }
    .estado-verde {
        background-color: #2ecc71;
        color: white;
    }
    .estado-cinzento {
        background-color: #bdc3c7;
        color: black;
    }
</style>

<div class="mb-4 flex items-center gap-2">
    <span class="font-semibold">Estado atual:</span>
    <span class="badge 
                 estado-{{ strtolower(str_replace(' ', '', $cor)) }}" 
          style="padding:6px 12px; font-size:14px; border-radius:6px;">
        {{ $estadoDescricao }}
    </span>
</div>




        {{-- ABAS --}}
        <div class="border-b mb-5">
            <ul class="flex flex-wrap gap-2 text-sm font-medium">

                <li>
                    <button class="tab-link px-4 py-2 rounded-t-lg border-b-2 border-blue-600 text-blue-600 font-semibold"
                            data-tab="tecnicos">
                        Dados Técnicos
                    </button>
                </li>

                <li>
                    <button class="tab-link px-4 py-2 rounded-t-lg border-b-2 border-transparent hover:text-blue-700 hover:border-blue-300 transition"
                            data-tab="faturacao">
                        Dados Faturação
                    </button>
                </li>

                <li>
                    <button class="tab-link px-4 py-2 rounded-t-lg border-b-2 border-transparent hover:text-blue-700 hover:border-blue-300 transition"
                            data-tab="anexos">
                        Anexos
                    </button>
                </li>
            </ul>
        </div>


        {{-- CONTENT --}}
        <div>

           {{-- DADOS TÉCNICOS --}}
            <div class="tab-content" id="tecnicos">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                    <tbody>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-2 text-left text-gray-600 w-1/3">Nome</th>
                            <td class="px-4 py-2">{{ $cadastro->nome }}</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <th class="px-4 py-2 text-left text-gray-600">Email</th>
                            <td class="px-4 py-2">{{ $cadastro->email }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-2 text-left text-gray-600">Contato</th>
                            <td class="px-4 py-2">{{ $cadastro->contato }}</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <th class="px-4 py-2 text-left text-gray-600">Estado Atual</th>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-white
                                    @if($estadoDescricao == 'Submetido') bg-blue-600
                                    @elseif($estadoDescricao == 'Para Correção') bg-yellow-400 text-black
                                    @elseif($estadoDescricao == 'Aguarda pagamento') bg-pink-500
                                    @elseif($estadoDescricao == 'Pagamento efectuado') bg-green-600
                                    @else bg-gray-400 text-black @endif">
                                    {{ $estadoDescricao }}
                                </span>
                            </td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-2 text-left text-gray-600">Nº Cadastro</th>
                            <td class="px-4 py-2">{{ $cadastro->numcadastro }}</td>
                        </tr>
                        <tr class="bg-white">
                            <th class="px-4 py-2 text-left text-gray-600">Data Entrada</th>
                            <td class="px-4 py-2">{{ $cadastro->data_entrada }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- DADOS DE FATURAÇÃO --}}
            <div class="tab-content hidden" id="faturacao">
                <table class="w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                    <tbody>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-2 text-left text-gray-600 w-1/3">Nome Faturação</th>
                            <td class="px-4 py-2">{{ $cadastro->nomeFaturacao ?? '-' }}</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <th class="px-4 py-2 text-left text-gray-600">NIF</th>
                            <td class="px-4 py-2">{{ $cadastro->nifFaturacao ?? '-' }}</td>
                        </tr>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-4 py-2 text-left text-gray-600">Morada</th>
                            <td class="px-4 py-2">{{ $cadastro->moradaFaturacao ?? '-' }}</td>
                        </tr>
                        <tr class="bg-white border-b">
                            <th class="px-4 py-2 text-left text-gray-600">Código Postal</th>
                            <td class="px-4 py-2">{{ $cadastro->codigoPostalFaturacao ?? '-' }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left text-gray-600">Localidade</th>
                            <td class="px-4 py-2">{{ $cadastro->localidadeFaturacao ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>


            {{-- ANEXOS --}}
            <div class="tab-content hidden" id="anexos">
                <table class="w-full text-left border shadow rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-3 py-2">Ficheiro</th>
                            <th class="px-3 py-2">Tipo</th>
                            <th class="px-3 py-2">Data Entrada</th>
                            <th class="px-3 py-2">Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cadastro->anexos as $anexo)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-3 py-2">{{ $anexo->ficheiro }}</td>
                            <td class="px-3 py-2">{{ $anexo->tipo }}</td>
                            <td class="px-3 py-2">{{ $anexo->data_entrada }}</td>
                            <td class="px-3 py-2">
                                <a href="{{ route('download.anexo', $anexo->id) }}" class="text-blue-600 font-semibold hover:underline">
                                    Download
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-3 text-gray-500">Nenhum anexo disponível</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>



{{-- MODAL --}}

@if($estadoAguarda)
<div id="aguarda-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-xl shadow-xl w-96 animate-fadeIn">
        <h3 class="mb-4 font-semibold text-lg text-gray-800">Confirmar Alteração</h3>
        <p class="mb-4 text-gray-600">Alterar o estado para <strong>"Aguarda Pagamento"</strong>?</p>
        <form action="{{ route('cadastros.updateEstado', $cadastro->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado_id" value="{{ $estadoAguarda->id }}">
            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Sim</button>
                <button type="button" data-modal-toggle="aguarda-modal" class="px-4 py-2 bg-gray-300 text-black rounded-lg">Cancelar</button>
            </div>
        </form>
    </div>
</div>
@endif

@if($estadoCorrecao)
<div id="correcao-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-xl shadow-xl w-96 animate-fadeIn">
        <h3 class="mb-4 font-semibold text-lg text-gray-800">Confirmar Alteração</h3>
        <p class="mb-4 text-gray-600">Alterar o estado para <strong>"Para Correção"</strong>?</p>
        <form action="{{ route('cadastros.updateEstado', $cadastro->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="estado_id" value="{{ $estadoCorrecao->id }}">
            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">Sim</button>
                <button type="button" data-modal-toggle="correcao-modal" class="px-4 py-2 bg-gray-300 text-black rounded-lg">Cancelar</button>
            </div>
        </form>
    </div>
</div>
@endif



{{-- SCRIPTS --}}
<script>
    // Trocar de abas
    document.querySelectorAll('.tab-link').forEach(tab => {
        tab.addEventListener('click', () => {

            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(tab.dataset.tab).classList.remove('hidden');

            document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('border-blue-600', 'text-blue-600', 'font-semibold'));
            tab.classList.add('border-blue-600', 'text-blue-600', 'font-semibold');
        });
    });

    // Modais
    document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.modalToggle);
            modal.classList.toggle('hidden');
        });
    });
</script>

@endsection
