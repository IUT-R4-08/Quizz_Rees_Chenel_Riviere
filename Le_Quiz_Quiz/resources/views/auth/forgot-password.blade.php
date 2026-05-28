@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-3">Mot de passe oublié</h4>
                <p class="text-muted small mb-4">
                    Renseignez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>

                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required autofocus>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Envoyer le lien</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection