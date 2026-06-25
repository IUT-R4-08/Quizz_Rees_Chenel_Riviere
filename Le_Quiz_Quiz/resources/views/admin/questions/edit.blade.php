@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 700px">

    <h1>Modifier la question</h1>

    <h4 class="mb-3">Thème : {{ $theme->nom }}</h4>

    <form method="POST" action="{{ route('admin.questions.update', [$theme, $question]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Question</label>
            <textarea name="question" class="form-control" required>
                {{ $question->question }}
            </textarea>
        </div>

        <hr>

        <h5>Réponses</h5>

        @foreach($question->answers as $i => $answer)
            <div class="mb-2 d-flex gap-2 align-items-center">

                <input type="radio"
                       name="correct"
                       value="{{ $i }}"
                       {{ $answer->is_correct ? 'checked' : '' }}
                       required>

                <input type="text"
                       name="answers[{{ $i }}][answer]"
                       class="form-control"
                       value="{{ $answer->answer }}"
                       required>

            </div>
        @endforeach

        <button class="btn btn-primary mt-3">
            Enregistrer
        </button>

        <a href="{{ route('admin.questions.index', $theme) }}" class="btn btn-secondary mt-3">
            Annuler
        </a>

    </form>

</div>
@endsection