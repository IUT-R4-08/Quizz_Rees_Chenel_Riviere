@extends('layouts.app')

@section('title', 'Confirmer le mot de passe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-3">Confirmation requise</h4>
                <p class="text-muted small mb-4">
                    Cette zone est protégée. Veuillez confirmer votre mot de passe avant de continuer.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection