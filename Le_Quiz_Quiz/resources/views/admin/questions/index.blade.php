@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a href="{{ route('admin.themes.index') }}" class="btn btn-secondary">
                    ← Retour aux thèmes
                </a>
            </div>

            <h1>Questions - {{ $theme->nom }}</h1>

            <a href="{{ route('admin.questions.create', $theme) }}" class="btn btn-success">
                + Ajouter une question
            </a>
        </div>

        @foreach($questions as $question)
            <div class="card mb-3">
                <div class="card-body">

                    <h5>{{ $question->question }}</h5>

                    <ul>
                        @foreach($question->answers as $answer)
                            <li>
                                {{ $answer->answer }}
                                @if($answer->is_correct)
                                    <strong class="text-success">(bonne réponse)</strong>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-2">

                        <a href="{{ route('admin.questions.edit', [$theme, $question]) }}" class="btn btn-sm btn-warning">
                            Modifier
                        </a>

                        <form action="{{ route('admin.questions.destroy', [$theme, $question]) }}" method="POST"
                            style="display:inline">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette question ?')">
                                Supprimer
                            </button>

                        </form>

                    </div>

                </div>
            </div>
        @endforeach

    </div>
@endsection