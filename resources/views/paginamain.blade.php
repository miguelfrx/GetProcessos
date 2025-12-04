<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main GetPrincipal</title>
    <link rel="icon" type="image/png" href="img/favicon.png">
    

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
@include('partials.header')
<body class="relative font-body">

    <!-- Imagem de fundo -->
    <div class="fixed inset-0 -z-10">
        <img 
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            class="w-full h-full object-cover"
            alt="Background"
        >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
    </div>

    <!-- Sidebar -->
    <aside id="default-sidebar" 
        class="fixed top-20 left-0 z-40 w-64 h-[calc(100%-5rem)] transition-transform -translate-x-full sm:translate-x-0 bg-white bg-opacity-90 backdrop-blur-md border-r border-gray-200">
        
        <div class="h-full px-3 py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">

                <li>
                    <a href="#" class="flex items-center px-2 py-2 text-gray-800 rounded hover:bg-gray-100">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-2 text-gray-800 rounded hover:bg-gray-100">
                        Kanban
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-2 text-gray-800 rounded hover:bg-gray-100">
                        Inbox
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-2 text-gray-800 rounded hover:bg-gray-100">
                        Users
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-2 py-2 text-gray-800 rounded hover:bg-gray-100">
                        Processos 
                    </a>
                </li>

                <!-- Tópico Cadastros -->
                <li class="mt-2">
                    <span class="flex items-center px-2 py-2 text-gray-900 font-semibold">
                        Cadastros
                    </span>

                    <!-- Subitens -->
                    <ul class="pl-6 mt-1 space-y-1">
                        <li class="flex justify-between items-center relative">
                            <a href="{{ url('/todos-cadastros') }}" 
                               class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                                Todos Cadastros
                            </a>
                            @if(isset($todosCadastrosCount) && $todosCadastrosCount > 0)
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                                    {{ $todosCadastrosCount > 99 ? '99+' : $todosCadastrosCount }}
                                </span>
                            @endif
                        </li>

                        <!--<li class="flex justify-between items-center relative">
                            <a href="{{ url('/tratar-cadastros') }}" 
                               class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                                A Tratar
                            </a>
                            @if(isset($tratarCadastrosCount) && $tratarCadastrosCount > 0)
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                                    {{ $tratarCadastrosCount > 99 ? '99+' : $tratarCadastrosCount }}
                                </span>
                            @endif
                        </li> -->
                    </ul>
                </li>

            </ul>
        </div>
    </aside>

    <!-- Conteúdo principal -->
    <div class="p-4 sm:ml-64 mt-20">
        <div class="p-4 border border-dashed rounded bg-white bg-opacity-90 backdrop-blur-md shadow-lg">
            
            <h1 class="text-2xl font-bold mb-4 text-gray-900">
                Bem-vindo à Página Principal!
            </h1>

            <div class="grid grid-cols-3 gap-4 mb-4">
                <div class="flex items-center justify-center h-24 rounded bg-gray-200 bg-opacity-70">
                    Bloco 1
                </div>
                <div class="flex items-center justify-center h-24 rounded bg-gray-200 bg-opacity-70">
                    Bloco 2
                </div>
                <div class="flex items-center justify-center h-24 rounded bg-gray-200 bg-opacity-70">
                    Bloco 3
                </div>
            </div>

            <div class="flex items-center justify-center h-48 rounded bg-gray-200 bg-opacity-70 mb-4">
                Bloco grande
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="flex items-center justify-center h-24 rounded bg-gray-200 bg-opacity-70">Bloco 4</div>
                <div class="flex items-center justify-center h-24 rounded bg-gray-200 bg-opacity-70">Bloco 5</div>
            </div>

        </div>
    </div>

    @include('partials.footer')

</body>
</html>
