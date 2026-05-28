@extends('layouts.app')

@section('title', 'Vérification email')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="card-title mb-3">Vérifiez votre email</h4>
                <p class="text-muted small mb-4">
                    Merci de vous être inscrit ! Avant de continuer, vérifiez votre boîte mail et cliquez sur le lien de vérification.
                    Si vous n'avez pas reçu d'email, nous pouvons vous en renvoyer un.
                </p>

                @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Renvoyer l'email</button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted small p-0">Se déconnecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection