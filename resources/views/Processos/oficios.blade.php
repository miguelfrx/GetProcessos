@extends('layouts.app')

@section('content')

{{-- Importar o estilo do Quill Editor --}}
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div class="fixed inset-0 -z-10">
    <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80" class="w-full h-full object-cover" alt="Background">
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>
</div>

@include('partials.sidebar')
@include('partials.header')

<div class="p-4 sm:ml-64 mt-20">
    <div class="p-8 bg-white/90 backdrop-blur-md rounded-xl shadow-xl border border-gray-200 animate-fadeIn">

        <div class="flex justify-between items-center mb-8 border-b border-gray-300 pb-4">
            <div>
                <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Gerar Novo Ofício</h2>
                <p class="text-gray-600 mt-1">Utilize o editor abaixo para formatar o texto do documento.</p>
            </div>
            <div class="bg-blue-600 p-3 rounded-lg shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
        </div>

        <form action="{{ route('oficios.generate') }}" method="POST" id="formOficio" target="_blank">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Processo Relacionado</label>
                    <select name="processo_id" class="w-full bg-white/50 border border-gray-300 rounded-lg p-3 transition" required>
                        <option value="">Selecione o número do processo...</option>
                        @foreach($processos as $p)
                        <option value="{{ $p->id }}">{{ $p->numero_processo }} - {{ $p->requerente }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Assunto do Ofício</label>
                    <input type="text" name="assunto" class="w-full bg-white/50 border border-gray-300 rounded-lg p-3 transition" required>
                </div>
            </div>

            <div class="mb-8 space-y-2">
                <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider">Conteúdo Técnico</label>

                <div class="bg-white rounded-lg border border-gray-300">
                    <div id="toolbar">
                        <span class="ql-formats">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                        </span>
                        <span class="ql-formats">
                            <button class="ql-clean"></button>
                        </span>
                    </div>
                    <div id="editor" style="height: 300px;" class="text-lg"></div>
                </div>

                <input type="hidden" name="conteudo" id="conteudo">
            </div>

            <div class="flex justify-end items-center gap-4 border-t border-gray-300 pt-6">
                <a href="{{ route('processos.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-lg font-semibold hover:bg-gray-200 transition border border-gray-300">Cancelar</a>

                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg font-bold shadow-lg hover:bg-blue-700 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Gerar PDF Formatado
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Scripts do Quill --}}
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    // Inicializar o Editor
    var quill = new Quill('#editor', {
        modules: {
            toolbar: '#toolbar'
        },
        theme: 'snow',
        placeholder: 'Escreva o texto do ofício aqui...'
    });

    // Antes de enviar o formulário, passar o HTML do editor para o input hidden
    var form = document.getElementById('formOficio');
    form.onsubmit = function() {
        var conteudo = document.querySelector('input[name=conteudo]');
        // Pegamos o conteúdo em formato HTML para manter o negrito/listas no PDF
        conteudo.value = quill.root.innerHTML;
        return true;
    };
</script>

<style>
    .ql-toolbar.ql-snow {
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
        background: #f9fafb;
    }

    .ql-container.ql-snow {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
        background: white;
        font-size: 1rem;
    }

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

    x .animate-fadeIn {
        animation: fadeIn 0.5s ease-out forwards;
    }
</style>

@endsection