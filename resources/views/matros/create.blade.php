@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="mb-4 fw-semibold">➕ Nouveau matériel roulant</h2>

  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
      <form action="{{ route('matros.store') }}" method="POST">
        @csrf
        @include('matros._form', ['matro' => new \App\Models\Matro])
      </form>
    </div>
  </div>
</div>
@endsection
