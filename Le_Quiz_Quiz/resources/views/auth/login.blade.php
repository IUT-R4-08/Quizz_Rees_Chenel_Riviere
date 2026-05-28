@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-4">Connexion</h4>

                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required autofocus autocomplete="username">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted small">Mot de passe oublié ?</a>
                        @endif
                        <button type="submit" class="btn btn-primary ms-auto">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center mt-3 small text-muted">
            Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
        </p>
    </div>
</div>
@endsection