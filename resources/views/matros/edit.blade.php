@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h2 class="mb-4 fw-semibold">✏️ Modifier matériel roulant</h2>

  <div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
      <form action="{{ route('matros.update', $matro) }}" method="POST">
        @csrf
        @method('PUT')
        @include('matros._form', ['matro' => $matro])
      </form>
    </div>
  </div>
</div>
@endsection
