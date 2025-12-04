<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome GetProcessos</title>
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative h-screen bg-gray-900">

    <!-- Imagem de fundo -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&w=1950&q=80" 
             alt="Background" 
             class="w-full h-full object-cover">
        <!-- Overlay para contraste -->
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Conteúdo central -->
    <div class="relative z-10 flex items-center justify-center h-screen">
        <div class="text-center bg-white bg-opacity-90 backdrop-blur-md shadow-2xl p-10 rounded-2xl max-w-md">
            
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                Gestão Processos
            </h1>

            <p class="text-gray-600 mb-6">
                Clique no botão abaixo para aceder ao login.
            </p>

            <a href="/login"
               class="inline-block text-white bg-blue-600 hover:bg-blue-700 font-semibold px-6 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
               Ir para Login
            </a>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>

