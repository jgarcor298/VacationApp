<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <div id="app" class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-md navbar-light bg-white sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-airplane-fill me-2" viewBox="0 0 16 16">
                        <path d="M6.428 1.151C6.708.591 7.213 0 7.8 0s1.092.592 1.372 1.151C9.451 1.771 13.527 2.235 15.683 2C15.86 1.983 16 2.13 16 2.308a1.6 1.6 0 0 1-.48 1.155c-.26.242-1.748 1.616-4.045 2.748L11.5 12h.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H10v.5a.5.5 0 0 1-1 0v-.5H7v.5a.5.5 0 0 1-1 0v-.5H4.5a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h.5L5.025 6.212c-2.298-1.132-3.785-2.506-4.045-2.748A1.6 1.6 0 0 1 .5 2.308C.499 2.149.63 1.992.81 2c2.147.23 6.204-.236 6.518-.849Z"/>
                    </svg>
                    {{ config('app.name', 'Destino Paraíso') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('vacacion.index') }}">Paquetes</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->isAdmin())
                                        <a class="dropdown-item" href="{{ route('users.index') }}">
                                            Gestión de Usuarios
                                        </a>
                                    @endif
                                    @if(Auth::user()->isAdmin() || Auth::user()->isAdvanced())
                                        <a class="dropdown-item" href="{{ route('reservas.index') }}">
                                            Gestión de Reservas
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="flex-grow-1">
            @yield('content')
        </main>

        <footer class="footer mt-auto">
            <div class="container text-center">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <h5 class="text-white mb-3">Destino Paraíso</h5>
                        <p class="small text-white-50">Explora el mundo con nosotros. Te ofrecemos las mejores experiencias vacacionales a precios inigualables.</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5 class="text-white mb-3">Enlaces Rápidos</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('vacacion.index') }}">Paquetes</a></li>
                            <li><a href="#">Sobre Nosotros</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-3">
                        <h5 class="text-white mb-3">Síguenos</h5>
                        <a href="#" class="me-2">Facebook</a>
                        <a href="#" class="me-2">Instagram</a>
                        <a href="#">Twitter</a>
                    </div>
                </div>
                <hr>
                <p class="mb-0 small text-white-50">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
</body>
</html>
