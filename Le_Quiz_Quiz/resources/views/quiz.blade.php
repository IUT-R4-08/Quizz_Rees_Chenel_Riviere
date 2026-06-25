@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="text-center mb-5">
                    <h1 class="display-5 fw-bold text-primary">{{ $theme->nom }}</h1>
                    <p class="text-muted">Répondez à toutes les questions avant de valider.</p>
                </div>

                <form action="{{ route('quiz.submit', $theme) }}" method="POST">
                    @csrf

                    @foreach($theme->questions as $question)
                        <div class="card shadow-sm mb-4 border-0 rounded-3">
                            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                                <h5 class="card-title fw-semibold">
                                    <span class="badge bg-secondary me-2">Question {{ $loop->iteration }}</span>
                                    {{ $question->question }}
                                </h5>
                            </div>

                            <div class="card-body px-4 pb-4">
                                <div class="choices-group">
                                    @foreach($question->answers as $answer)

                                        <div
                                            class="form-check d-flex align-items-center p-0 my-2 border rounded-3 bg-light transition-all hover-style">

                                            <input class="form-check-input my-0 ms-3" type="radio"
                                                name="question_{{ $question->id }}" id="answer_{{ $answer->id }}"
                                                value="{{ $answer->id }}" required>

                                            <label class="form-check-label py-3 pe-3 ps-2 flex-grow-1" style="cursor: pointer;"
                                                for="answer_{{ $answer->id }}">
                                                {{ $answer->answer }}
                                            </label>

                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm py-3 fw-bold">
                            Valider mes réponses
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection