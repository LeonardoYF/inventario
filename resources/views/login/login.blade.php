@extends('layouts.app')
@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  <div class="card p-4" style="width: 350px;">
    <div class="text-center mb-4">
      <i class="bi bi-person-circle" style="font-size: 4rem;"></i>
    </div>
    <h2 class="text-center mb-4">Iniciar sesión</h2>
    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="mb-3">
        <label for="email" class="form-label">Correo electrónico</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input id="password" type="password" class="form-control" name="password" required>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="remember" id="remember">
        <label class="form-check-label" for="remember">Recuérdame</label>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
      </div>
    </form>
  </div>
</div>
@endsection