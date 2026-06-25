@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('home') }}" class="btn btn-secondary">
                    ← Retour à l'accueil
                </a>
            </div>

            <h1>Gestion des thèmes</h1>

            <a href="{{ route('admin.themes.create') }}" class="btn btn-success">+ Ajouter</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Icône</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($themes as $theme)
                    <tr>
                        <td>{{ $theme->icone }}</td>
                        <td>{{ $theme->nom }}</td>
                        <td>{{ $theme->description }}</td>
                        <td>
                            <a href="{{ route('admin.themes.edit', $theme) }}" class="btn btn-sm btn-warning">
                                Modifier
                            </a>

                            <a href="{{ route('admin.questions.index', $theme) }}" class="btn btn-sm btn-primary">
                                Gérer les questions
                            </a>

                            <form action="{{ route('admin.themes.destroy', $theme) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Supprimer ?')" class="btn btn-sm btn-danger">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection