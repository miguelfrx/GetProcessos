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
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
    </div>

    <!-- Conteúdo central -->
    <div class="relative z-10 flex flex-col items-center justify-center h-screen space-y-6">

        <!-- Título -->
        <h1 class="text-5xl font-bold text-white drop-shadow-lg">
            Gestão Processos
        </h1>

        <!-- Logotipo maior e responsivo -->
        <img src="img/esposende-ambiente-alt-1920x295.png" alt="Logotipo" class="w-96 h-96 md:w-[500px] md:h-[500px] object-contain">

        <!-- Botão de login -->
        <a href="/login"
           class="mt-4 inline-block text-white bg-blue-600 hover:bg-blue-700 font-semibold px-8 py-3 rounded-lg shadow-lg transition transform hover:scale-105">
           Ir para Login
        </a>
    </div>

    @include('partials.footer')

</body>
</html>
