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

                <!-- Botão abrir modal -->
<button id="abrir-anexo-modal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
    Adicionar Anexo
</button>

<!-- Modal -->
<div id="anexo-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white p-6 rounded-xl shadow-xl w-full max-w-md">

        <h3 class="mb-4 font-semibold text-lg text-gray-800">Adicionar Anexo</h3>

        <form action="{{ route('anexos.store', $cadastro->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Tipo -->
            <div class="mb-4">
                <label class="block mb-2 text-sm font-medium text-gray-700">Tipo de Anexo</label>
                <select name="tipo" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                    <option value="comprovativo">Comprovativo</option>
                    <option value="recibo">Recibo</option>
                </select>
            </div>

            <!-- DROPZONE -->
            <div class="flex items-center justify-center w-full mb-4">
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-52 bg-neutral-secondary-medium border border-dashed border-gray-400 rounded-lg cursor-pointer hover:bg-gray-100 transition"
                    id="dropzone-label">

                    <div class="flex flex-col items-center justify-center text-gray-600 pt-5 pb-6 text-center">
                        <svg class="w-8 h-8 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2"
                                d="M12 16V4m0 0L8 8m4-4 4 4M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                        </svg>
                        <p class="text-sm">
                            <span class="font-semibold">Clique para carregar</span> ou arraste o ficheiro
                        </p>
                        <p class="text-xs mt-1">PDF, JPG, PNG</p>
                        <p id="file-name" class="text-xs mt-2 text-green-600 hidden"></p>
                    </div>

                    <input id="dropzone-file" name="ficheiro" type="file" class="hidden" required />
                </label>
            </div>

            <!-- Ações -->
            <div class="flex justify-end gap-2">
                <button type="submit"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Upload
                </button>

                <button type="button" id="fechar-anexo-modal"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Cancelar
                </button>
            </div>

        </form>
    </div>
</div>

<!-- SCRIPT -->
<script>
    const abrirModal = document.getElementById('abrir-anexo-modal');
    const fecharModal = document.getElementById('fechar-anexo-modal');
    const modal = document.getElementById('anexo-modal');

    const fileInput = document.getElementById('dropzone-file');
    const fileName = document.getElementById('file-name');
    const dropzone = document.getElementById('dropzone-label');

    abrirModal.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    fecharModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        resetDropzone();
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            resetDropzone();
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileName.textContent = fileInput.files[0].name;
            fileName.classList.remove('hidden');
            dropzone.classList.add('border-green-500');
        }
    });

    function resetDropzone() {
        fileInput.value = '';
        fileName.textContent = '';
        fileName.classList.add('hidden');
        dropzone.classList.remove('border-green-500');
    }
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
