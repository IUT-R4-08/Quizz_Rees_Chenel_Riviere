@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px">
    <h1>{{ isset($theme) ? 'Modifier' : 'Ajouter' }} un thème</h1>

    <form method="POST" action="{{ isset($theme) ? route('admin.themes.update', $theme) : route('admin.themes.store') }}">
        @csrf
        @isset($theme) @method('PUT') @endisset

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $theme->nom ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Icône (emoji)</label>
            <input type="text" name="icone" class="form-control" value="{{ old('icone', $theme->icone ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $theme->description ?? '') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.themes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection