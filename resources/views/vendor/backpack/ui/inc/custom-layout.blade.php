<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Incluí tus metas, estilos y scripts aquí -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="{{ config('backpack.theme-tabler.classes.body') }}">
    
    <!-- Aquí iría tu header o barra superior -->
    @include('backpack::inc.topbar')

    <div class="app">
        <!-- Sidebar -->
        @include('backpack::inc.sidebar')

        <!-- Contenido principal -->
        <main class="main">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer personalizado -->
    @include('backpack::ui.inc.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
