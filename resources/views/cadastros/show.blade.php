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
                        <!-- Botão Aguardar Pagamento -->
                        <button type="button" data-modal-target="aguarda-modal" data-modal-toggle="aguarda-modal" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            Aguardar Pagamento
                        </button>
                    @endif

                    @if($estadoCorrecao)
                        <!-- Botão Para Correção -->
                        <button type="button" data-modal-target="correcao-modal" data-modal-toggle="correcao-modal" class="px-4 py-2 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
                            Para Correção
                        </button>
                    @endif
                @endif
            </div>
        </div>

        {{-- Estado Atual com cores --}}
        @php
            $cores = [
                'Submetido' => 'azul',
                'Para Correção' => 'amarelo',
                'Aguardar Pagamento' => 'rosa',
                'Pagamento Efectuado' => 'verde'
            ];

            $estadoAtualDescricao = $cadastro->estado->descricao ?? 'Desconhecido';
            $ultimoHistorico = $cadastro->historico()->latest('data_hora')->first();
            $estadoAnteriorDescricao = $ultimoHistorico ? $ultimoHistorico->estadoAnterior->descricao : 'Sem Estado';
            $corAtual = $cores[$estadoAtualDescricao] ?? 'cinzento';
        @endphp

        <style>
            .estado-azul { background-color: #3498db; color: white; }
            .estado-amarelo { background-color: #f1c40f; color: black; }
            .estado-rosa { background-color: #ff66b2; color: white; }
            .estado-verde { background-color: #2ecc71; color: white; }
            .estado-cinzento { background-color: #bdc3c7; color: black; }
        </style>

        <div class="mb-4 flex items-center gap-2">
            <span class="font-semibold">Estado Atual:</span>
            <span class="badge estado-{{ strtolower(str_replace(' ', '', $corAtual)) }}" style="padding:6px 12px; font-size:14px; border-radius:6px;">
                {{ $estadoAtualDescricao }}
            </span>
        </div>

        {{-- ABAS --}}
        <div class="border-b mb-5">
            <ul class="flex flex-wrap gap-2 text-sm font-medium">
                <li>
                    <button class="tab-link px-4 py-2 rounded-t-lg border-b-2 border-blue-600 text-blue-600 font-semibold" data-tab="tecnicos">Dados Técnicos</button>
                </li>
                <li>
                    <button class="tab-link px-4 py-2 rounded-t-lg border-b-2 border-transparent hover:text-blue-700 hover:border-blue-300 transition" data-tab="faturacao">Dados Faturação</button>
                </li>
                <li>
                    <button class="tab-link px-4 py-2 rounded-t-lg border-b-2 border-transparent hover:text-blue-700 hover:border-blue-300 transition" data-tab="anexos">Anexos</button>
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
                            <th class="px-4 py-2 text-left text-gray-600">Estado Anterior</th>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-white
                                    @if($estadoAnteriorDescricao == 'Submetido') bg-blue-600
                                    @elseif($estadoAnteriorDescricao == 'Para Correção') bg-yellow-400 text-black
                                    @elseif($estadoAnteriorDescricao == 'Aguardar Pagamento') bg-pink-500
                                    @elseif($estadoAnteriorDescricao == 'Pagamento Efectuado') bg-green-600
                                    @else bg-gray-400 text-black @endif">
                                    {{ $estadoAnteriorDescricao }}
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

                {{-- TABELA DE ANEXOS EXISTENTES --}}
                <table class="w-full text-left border shadow rounded-lg overflow-hidden mb-6">
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

                <!--{{-- FORMULÁRIO DE UPLOAD --}}
                <form action="{{ route('anexos.store', $cadastro->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex items-center justify-center w-full">
                        <div class="flex flex-col items-center justify-center w-full h-64 bg-neutral-secondary-medium border border-dashed border-gray-300 rounded-lg p-4">
                            <div class="flex flex-col items-center justify-center text-body pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v9m-5 0H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2M8 9l4-5 4 5m1 8h.01"/>
                                </svg>
                                <p class="mb-2 text-sm">Clique no botão abaixo para escolher o ficheiro</p>
                                <p class="text-xs mb-4">Max. File Size: <span class="font-semibold">30MB</span></p>

                                <button type="button" onclick="document.getElementById('dropzone-file').click()" class="inline-flex items-center text-white bg-blue-600 hover:bg-blue-700 font-medium rounded px-3 py-2 mb-2">Escolher Ficheiro</button>

                                <span id="file-name" class="text-sm text-gray-700 mb-2"></span>

                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Upload</button>

                                <input id="dropzone-file" type="file" name="ficheiro" class="hidden" required onchange="document.getElementById('file-name').innerText = this.files[0]?.name || ''"/>
                            </div>
                        </div>
                    </div>
                </form> -->
                <!-- Botão para abrir o modal -->
<button type="button" data-modal-toggle="anexo-modal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
    Adicionar Anexo
</button>

<!-- Modal de anexos -->
<div id="anexo-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-xl shadow-xl w-96">
        <h3 class="mb-4 font-semibold text-lg text-gray-800">Adicionar Anexo</h3>
        <form action="{{ route('anexos.store', $cadastro->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="tipo" class="block mb-1 text-sm font-medium text-gray-700">Tipo de Anexo</label>
                <select name="tipo" id="tipo" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="Comprovativo">Comprovativo</option>
                    <option value="Recibo">Recibo</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="ficheiro" class="block mb-1 text-sm font-medium text-gray-700">Escolher ficheiro</label>
                <input type="file" name="ficheiro" id="ficheiro" class="w-full text-sm text-gray-700 border border-gray-300 rounded cursor-pointer" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Upload</button>
                <button type="button" data-modal-hide="anexo-modal" class="px-4 py-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts para abrir/fechar modal -->
<script>
    document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.modalToggle);
            modal.classList.remove('hidden');
        });
    });

    document.querySelectorAll('[data-modal-hide]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.modalHide);
            modal.classList.add('hidden');
        });
    });
</script>


                

            </div> 
        </div>
    </div>
</div>
{{-- MODAIS DE ALTERAÇÃO DE ESTADO --}}
@if($estadoAguarda)
<div id="aguarda-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-xl shadow-xl w-96 animate-fadeIn">
        <h3 class="mb-4 font-semibold text-lg text-gray-800">Confirmar Alteração</h3>
        <p class="mb-4 text-gray-600">Alterar o estado para <strong>"Aguardar Pagamento"</strong>?</p>
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

{{-- Mantém os teus scripts atuais --}}
<script>
    document.querySelectorAll('.tab-link').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(tab.dataset.tab).classList.remove('hidden');
            document.querySelectorAll('.tab-link').forEach(t => t.classList.remove('border-blue-600','text-blue-600','font-semibold'));
            tab.classList.add('border-blue-600','text-blue-600','font-semibold');
        });
    });

    document.querySelectorAll('[data-modal-toggle]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modal = document.getElementById(btn.dataset.modalToggle);
            modal.classList.toggle('hidden');
        });
    });
</script>






@endsection
