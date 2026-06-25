@extends('layouts.app')

@section('content')

<div class="container text-center mt-5">

    <h1>Résultat du quiz</h1>

    <h3 class="mt-4">
        {{ $theme->nom }}
    </h3>

    <div class="display-4 my-5">
        {{ $score }} / {{ $total }}
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary">
        Retour à l'accueil
    </a>

</div>

@endsection