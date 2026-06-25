<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quiz Quiz')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <style>
        .hover-style:hover {
            background-color: #e9ecef !important;
            border-color: #0d6efd !important;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/quiz">
                <img src="{{ asset('images/logo.png') }}" alt="Le Quizz Quizz" width="50" height="50"
                    class="d-inline-block align-text-top me-2 rounded-circle">

                <span class="fw-bold">Le Quizz Quizz</span>
            </a>
        </div>
    </nav>

    <main class="container my-4">
        @yield('content')
    </main>

</body>

</html>