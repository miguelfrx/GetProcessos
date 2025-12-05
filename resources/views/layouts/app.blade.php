<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gestão Processos')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    @include('partials.header')

    <!-- Conteúdo da página -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- sidebar -->
    @include('partials.sidebar')


    <!-- Footer -->
    @include('partials.footer')

</body>
</html>
