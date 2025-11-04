@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="mb-4 fw-semibold">🚛 Détail du matériel roulant</h2>

  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
      <dl class="row mb-0">
        <dt class="col-sm-4 text-muted">ID</dt>
        <dd class="col-sm-8">{{ $matro->id }}</dd>

        <dt class="col-sm-4 text-muted">ID Descent</dt>
        <dd class="col-sm-8">{{ $matro->id_descent }}</dd>

        <dt class="col-sm-4 text-muted">Désignation</dt>
        <dd class="col-sm-8">{{ $matro->designation }}</dd>

        <dt class="col-sm-4 text-muted">Marque</dt>
        <dd class="col-sm-8">{{ $matro->marque }}</dd>

        <dt class="col-sm-4 text-muted">Type</dt>
        <dd class="col-sm-8">{{ $matro->type }}</dd>

        <dt class="col-sm-4 text-muted">IMM</dt>
        <dd class="col-sm-8">{{ $matro->imm }}</dd>

        <dt class="col-sm-4 text-muted">Volume</dt>
        <dd class="col-sm-8">{{ $matro->volume }}</dd>
      </dl>

      <div class="mt-4 text-end">
        <a href="{{ route('matros.edit', $matro) }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">✏️ Modifier</a>
        <a href="{{ route('matros.index') }}" class="btn btn-outline-dark rounded-pill px-4">↩️ Retour</a>
      </div>
    </div>
  </div>
</div>
@endsection
