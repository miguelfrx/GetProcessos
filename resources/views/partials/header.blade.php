<nav class="fixed top-0 left-0 w-full z-50 backdrop-blur-lg bg-white/40 border-b border-gray-300/40 shadow-sm">
    <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">

        <!-- LOGO -->
        <a href="{{ url('/paginamain') }}" class="flex items-center space-x-3">
            <img src="{{ asset('img/esposende-ambiente-alt-1920x295.png') }}"
                 class="h-10 object-contain" alt="Logo" />
        </a>

        <!-- USER + MOBILE -->
        <div class="flex items-center space-x-4 md:order-2">

            <!-- Botão do usuário -->
            <button type="button"
                    id="user-menu-button"
                    data-dropdown-toggle="user-dropdown"
                    class="rounded-full p-1 border border-gray-400/40 hover:border-gray-500 transition">
                <img class="w-9 h-9 rounded-full"
                     src="{{ Auth::user()->profile_photo_url ?? asset('img/default-avatar.png') }}"
                     alt="{{ Auth::user()->name }}">
            </button>

            <!-- Dropdown -->
            <div id="user-dropdown"
                 class="hidden absolute right-6 mt-3 w-44 z-[9999]
                        bg-white/80 backdrop-blur-xl rounded-lg shadow-xl border border-gray-300/40 text-gray-800">

                <div class="px-4 py-3 text-sm border-b border-gray-300/40">
                    <p class="font-semibold">{{ Auth::user()->name }}</p>
                    <p class="text-gray-600 truncate">{{ Auth::user()->email }}</p>
                </div>

                <ul class="p-2 text-sm">
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-200/50">Dashboard</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-200/50">Settings</a></li>
                    <li><a href="#" class="block px-3 py-2 rounded hover:bg-gray-200/50">Earnings</a></li>
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="block px-3 py-2 rounded hover:bg-gray-200/50">
                           Sign out
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Formulário de logout -->
            <form id="logout-form" action="{{ route('logout') }}" class="hidden" method="POST">@csrf</form>

            <!-- Botão toggle mobile -->
            <button data-collapse-toggle="navbar-user" type="button"
                    class="md:hidden p-2 rounded hover:bg-gray-200/60 transition">
                <svg class="w-7 h-7 text-gray-800" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

        </div>

        <!-- LINKS MENU -->
        <div class="hidden md:flex space-x-8 md:order-1" id="navbar-user">
            <a href="{{ url('/paginamain') }}" class="text-gray-900 hover:text-gray-700 transition">Home</a>
            <a href="#" class="text-gray-900 hover:text-gray-700 transition">About</a>
            <a href="#" class="text-gray-900 hover:text-gray-700 transition">Services</a>
            <a href="#" class="text-gray-900 hover:text-gray-700 transition">Pricing</a>
            <a href="#" class="text-gray-900 hover:text-gray-700 transition">Contact</a>
        </div>

    </div>
</nav>

<!-- Flowbite JS -->
<script src="https://unpkg.com/flowbite@1.7.0/dist/flowbite.js"></script>
