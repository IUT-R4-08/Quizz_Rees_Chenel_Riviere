@extends('layouts.app')

@section('title', 'Accueil - Quiz Quiz')

@section('content')

    <h1 class="text-center mb-2">Bienvenue sur Quiz Quiz</h1>
    <p class="text-center text-muted mb-5">Choisis un thème et teste tes connaissances !</p>

    <div class="row g-4">

        @foreach ($themes as $theme)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <h5 class="card-title mt-2">{{ $theme['nom'] }}</h5>
                        <p class="card-text text-muted">{{ $theme['description'] }}</p>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/quiz/{{ $theme['slug'] }}" class="btn btn-primary">
                            Jouer
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

@endsection