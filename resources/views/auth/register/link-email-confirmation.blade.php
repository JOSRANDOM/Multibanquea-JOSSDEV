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

        <h1 class="mb-4">Revisa tu correo electrónico</h1>

        <div class="mb-4">Te hemos enviado un correo electrónico a <b>{{ $email }}</b>. Ábrelo y da clic en el enlace para continuar con el proceso de verificación.</div>

      </div>
    </div>
    <div class="col-6 bg-primary d-none d-md-flex auth-img-login">
    </div>
  </div>
</div>
@endsection
