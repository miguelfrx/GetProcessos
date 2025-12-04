<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative h-screen w-screen overflow-hidden font-body">

    <!-- Imagem de fundo -->
    <div class="absolute inset-0">
        <img 
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            alt="Background"
            class="w-full h-full object-cover"
        >
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Conteúdo principal -->
    <div class="relative z-10 flex flex-col items-center justify-center px-6 py-8 mx-auto h-full">

        <div class="w-full bg-white bg-opacity-90 backdrop-blur-md rounded-lg shadow-xl sm:max-w-md p-8">
            
            <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">
                Criar Conta
            </h1>

            <form class="space-y-4 md:space-y-6" action="{{ route('register.post') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900 mb-1">Nome</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        placeholder="Seu nome" 
                        required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 mb-1">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        placeholder="email@exemplo.com" 
                        required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-900 mb-1">Senha</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="••••••••" 
                        required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-900 mb-1">Confirme a senha</label>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        id="password_confirmation" 
                        placeholder="••••••••" 
                        required
                        class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <button 
                    type="submit" 
                    class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded text-sm px-4 py-2.5">
                    Criar Conta
                </button>

                <p class="text-sm font-light text-white-100 text-center mt-4">
                    Já tem conta?  
                    <a href="{{ url('/login') }}" class="font-medium text-blue-300 hover:underline">
                        Login aqui
                    </a>
                </p>
            </form>
        </div>

    </div>

</body>
</html>
