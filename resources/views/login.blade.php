<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login GetProcessos</title>
    
    <link rel="icon" type="image/png" href="/img/favicon.png">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="relative h-screen w-screen overflow-hidden">

    <!-- Imagem de fundo -->
    <div class="absolute inset-0">
        <img 
            src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80"
            alt="Background"
            class="w-full h-full object-cover"
        >
        <!-- Overlay escuro -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Conteúdo principal (formulário) -->
    <div class="relative z-10 flex items-center justify-center h-full">
        <form method="POST" action="/login" class="max-w-sm w-full bg-white bg-opacity-90 backdrop-blur-md p-6 rounded-lg shadow-xl">
            @csrf

            <h1 class="text-2xl font-bold text-center mb-6 text-gray-800">Login</h1>

            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                    Your email
                </label>
                <input 
                    type="email" 
                    id="email"
                    name="email"
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded w-full px-3 py-2 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="name@example.com" 
                    required
                />
            </div>

            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                    Your password
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    class="bg-gray-200 border border-gray-300 text-gray-900 text-sm rounded w-full px-3 py-2 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="••••••••" 
                    required
                />
            </div>

            <label for="remember" class="flex items-center mb-4 cursor-pointer">
                <input 
                    id="remember" 
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 border-gray-300 rounded bg-gray-200 focus:ring-blue-500"
                />
                <span class="ml-2 text-sm text-gray-900">
                    I agree with the <a href="#" class="text-blue-500 hover:underline">terms and conditions</a>.
                </span>
            </label>

            <button 
                type="submit" 
                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded w-full text-sm px-4 py-2">
                Entrar
            </button>

            <p class="text-sm text-white-200 text-center mt-4">
                Ainda não tem conta?  
                <a href="{{ url('/register') }}" class="font-medium text-blue-300 hover:underline">
                    Criar conta
                </a>
            </p>
        </form>
    </div>

</body>
</html>
