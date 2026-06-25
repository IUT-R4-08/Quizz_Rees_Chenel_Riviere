@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px">

    <h1>Ajouter une question</h1>

    <h4 class="mb-3">
        Thème : {{ $theme->nom }}
    </h4>

    <form method="POST" action="{{ route('admin.questions.store', $theme) }}">
        @csrf

        {{-- QUESTION --}}
        <div class="mb-3">
            <label>Question</label>
            <textarea name="question" class="form-control" required></textarea>
        </div>

        <hr>

        {{-- REPONSES --}}
        <h5>Réponses (4)</h5>

        @for($i = 0; $i < 4; $i++)
            <div class="mb-2 d-flex gap-2 align-items-center">

                <input type="radio" name="correct" value="{{ $i }}" required>

                <input type="text"
                       name="answers[{{ $i }}][answer]"
                       class="form-control"
                       placeholder="Réponse {{ $i + 1 }}"
                       required>

            </div>
        @endfor

        <button type="submit" class="btn btn-primary mt-3">
            Enregistrer
        </button>

        <a href="{{ route('admin.themes.index') }}" class="btn btn-secondary mt-3">
            Annuler
        </a>
    </form>

</div>
@endsection