@extends('layouts.minimal')
@section('head.title', 'Ingresar a ' . config('app.name'))
@section('head.robots', 'noindex, follow')

@section('content')
<div class="container-fluid">
  <div class="row mt-4 mt-mb-0 min-vh-md-100">
    <div class="col-12 col-md-6 bg-white d-flex align-items-center">
      <div class="px-3 px-lg-5 mx-auto" style="max-width: 480px;">

        <a class="d-block mb-4" href="{{ route('welcome') }}" title="Ir a la página principal">
          <img src="{{ asset('/img/brand/' . config('variant.name') . '/logo-color-300.png') }}" alt="{{ config('app.name') }}" height="30">
        </a>

        <h1 class="mb-4">Ingresar</h1>

        <div class="mb-4">Ingresa con tu cuenta personal para guardar tu progreso individual y obtener un análisis personalizado de tu rendimiento.</div>

        <div class="mb-3">
          <a href="{{ route('oauth', 'facebook') }}" class="btn d-block btn-primary">{{ __('Ingresar con Facebook') }}</a>
        </div>
        <div class="mb-3">
          <a href="{{ route('oauth', 'google') }}" class="btn d-block btn-primary">{{ __('Ingresar con Google') }}</a>
        </div>
        <div class="mb-4">
          <a href="{{ route('login-students') }}" class="btn d-block btn-primary">{{ __('Ingreso para Estudiantes') }}</a>
        </div>

        <div>
          Al ingresar por primera vez quedarás registrada/o en {{ config('app.name') }} y aceptarás nuestro <a href="{{ route('legal.terms') }}" target="_blank">aviso legal y condiciones de uso</a>.
        </div>

      </div>
    </div>
    <div class="col-6 bg-primary d-none d-md-flex auth-img-login">
    </div>
  </div>
</div>
@endsection
