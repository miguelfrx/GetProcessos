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

    @include('partials.sidebar')
    @if(session('success'))
    <div 
        id="toast-success" 
        class="fixed top-5 right-5 bg-green-500 text-white px-4 py-3 rounded shadow-lg transform transition-all duration-500 opacity-0 z-[9999]"
    >
        {{ session('success') }}
    </div>

    <script>
        const toast = document.getElementById('toast-success');
        toast.classList.remove('opacity-0');
        toast.classList.add('opacity-100');

        setTimeout(() => {
            toast.classList.remove('opacity-100');
            toast.classList.add('opacity-0');
        }, 3000);
    </script>
@endif


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
