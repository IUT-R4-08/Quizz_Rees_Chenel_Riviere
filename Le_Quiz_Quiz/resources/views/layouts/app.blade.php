<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Quiz Quiz'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                🎯 Quiz Quiz
            </a>
            <div class="d-flex align-items-center gap-2">

                @auth
                    <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm">
                        Quizz
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm">
                        Scores
                    </a>
                    <span class="text-white small ms-2">
                        {{ Auth::user()->name }}
                    </span>
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.themes.index') }}" class="btn btn-warning btn-sm">
                            ⚙️Admin
                        </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">
                            Déconnexion
                        </button>
                    </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">
                        Inscription
                    </a>
                @endguest
            </div>
        </div>
    </nav>
    <main class="container my-4">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>