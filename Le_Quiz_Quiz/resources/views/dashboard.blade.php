@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Mon dashboard</h1>
        @if($results->isEmpty())
            <div class="alert alert-info">
                Tu n'as pas encore joué de quiz.
            </div>
        @else
            <div class="alert alert-primary">
                Moyenne générale : {{ round($average) }}%
            </div>

            <div class="row">
                @foreach($results as $result)
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5>
                                    {{ $result->theme->icone }}
                                    {{ $result->theme->nom }}
                                </h5>
                                <p class="mb-1">
                                    Score : <strong>{{ $result->score }} / {{ $result->total_questions }}</strong>
                                </p>
                                <p class="mb-1">
                                    {{ round(($result->score / $result->total_questions) * 100) }}%
                                </p>
                                <small class="text-muted">
                                    {{ $result->created_at->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection