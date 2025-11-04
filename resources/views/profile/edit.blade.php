@extends('layouts.app')
@section('title', 'Édition du profil')
@section('content')
<div class="container py-5">
    <h2 class="mb-4">🧑‍💼 Édition du profil</h2>

    <!-- Informations du profil -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Informations du profil</div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="alert alert-warning">
                        Votre adresse email n'est pas vérifiée.
                        <button type="submit" form="send-verification" class="btn btn-sm btn-outline-secondary ms-2">Renvoyer le mail de vérification</button>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
            </form>

            <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
                @csrf
            </form>
        </div>
    </div>

    <!-- Changement de mot de passe -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">Changer le mot de passe</div>
        <div class="card-body">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-secondary">🔒 Mettre à jour</button>
            </form>
        </div>
    </div>

    <!-- Suppression du compte -->
    <div class="card">
        <div class="card-header bg-danger text-white">Supprimer le compte</div>
        <div class="card-body">
            <p>⚠️ Une fois votre compte supprimé, toutes vos données seront définitivement effacées.</p>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="mb-3">
                    <label for="delete_password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="delete_password" name="password" required>
                </div>

                <button type="submit" class="btn btn-danger">🗑️ Supprimer mon compte</button>
            </form>
        </div>
    </div>
</div>
@endsection
