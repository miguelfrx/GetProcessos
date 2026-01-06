<aside id="default-sidebar"
    class="fixed top-20 left-0 z-40 w-64 h-[calc(100%-5rem)] transition-transform -translate-x-full sm:translate-x-0 bg-white bg-opacity-90 backdrop-blur-md border-r border-gray-200">

    <div class="h-full px-3 py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">

            <li>
                <span class="flex items-center px-2 py-2 text-gray-900 font-semibold">
                    <i class="fas fa-folder mr-2 text-gray-600"></i>
                    Processos
                </span>

                <ul class="pl-6 mt-1 space-y-1">
                    <li>
                        <a href="{{ route('processos.index') }}"
                            class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                            Consultar Todos
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                            Informações
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('oficios.create') }}"
                            class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                            Ofícios
                        </a>
                    </li>
                </ul>
            </li>

            <hr class="my-2 border-gray-200">

            <li class="mt-2">
                <span class="flex items-center px-2 py-2 text-gray-900 font-semibold">
                    Cadastros
                </span>

                <ul class="pl-6 mt-1 space-y-1">
                    <li class="flex justify-between items-center relative">
                        <a href="{{ url('/todos-cadastros') }}"
                            class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                            Consultar
                        </a>
                        @if(isset($todosCadastrosCount) && $todosCadastrosCount > 0)
                        <span class="absolute right-0 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                            {{ $todosCadastrosCount > 99 ? '99+' : $todosCadastrosCount }}
                        </span>
                        @endif
                    </li>
                    <li class="flex justify-between items-center relative">
                        <a href="{{ url('/tratar-cadastros') }}"
                            class="block text-sm text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded px-2 py-1">
                            A Tratar
                        </a>
                        @if(isset($tratarCadastrosCount) && $tratarCadastrosCount > 0)
                        <span class="absolute right-0 top-1/2 transform -translate-y-1/2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold text-white bg-red-600 rounded-full">
                            {{ $tratarCadastrosCount > 99 ? '99+' : $tratarCadastrosCount }}
                        </span>
                        @endif
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>