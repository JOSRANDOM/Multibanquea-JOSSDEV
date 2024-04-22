@extends('layouts.minimal')
@section('head.robots', 'noindex, follow')

@section('content')
<div class="container-fluid">
  <div class="row mt-4 mt-mb-0 min-vh-md-100">
    <div class="col-12 col-md-6 bg-white d-flex align-items-center">
      <div class="px-3 px-lg-5 mx-auto" style="max-width: 480px;">

        <a class="d-block mb-4" href="{{ route('welcome') }}" title="Ir a la página principal">
          <img src="{{ asset('/img/brand/' . config('variant.name') . '/logo-color-300.png') }}" alt="{{ config('app.name') }}" height="30">
        </a>

        <h1 class="mb-4">Verifica tu correo electrónico</h1>

        @if ($errors->any())
        <div class="mb-4">
          <x-alert-error :errors="$errors->all()" />
        </div>
        @endif

        <div class="mb-4">Ingresa tu dirección de correo electrónico y recibirás un mensaje para verificarla.</div>

        <form method="POST" action="{{ route('register.requestLinkingEmail', [$o_auth_user, $email_requested_request_token]) }}">
          {{ csrf_field() }}
          <div class="mb-4">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" name="email" autocomplete="email" class="form-control" id="email" required>
          </div>
          <button type="submit" class="btn btn-primary">Verificar</button>
        </form>

      </div>
    </div>
    <div class="col-6 bg-primary d-none d-md-flex auth-img-login">
    </div>
  </div>
</div>
@endsection
