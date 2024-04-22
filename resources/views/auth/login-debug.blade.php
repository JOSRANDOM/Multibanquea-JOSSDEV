@extends('layouts.minimal')

@section('content')
<section class="section bg-soft d-flex align-items-center">
  <div class="container">
    <div class="alert alert-info" role="alert">
      <p>{{ __('¿Estás buscando la página normal para ingresar a ' . config('app.name') . '?') }}</p>
      <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Ingresar a ' . config('app.name') . ' de manera regular') }}</a>
    </div>
    <div class="row justify-content-center form-bg-image">
      <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="signin-inner mt-3 mt-lg-0 bg-white shadow-soft border border-light rounded p-4 p-lg-5 w-100 fmxw-500">
          <div class="text-center text-md-center mb-4 mt-md-0">
            <h1 class="h3 font-weight-bold mb-3">{{ __('Ingreso alternativo a ' . config('app.name')) }}</h1>
          </div>
          <div class="form-group text-center">{{ __('Utiliza esta página para ingresar a ' . config('app.name') . ' en caso tengas problemas accediendo de manera regular.') }}</div>
          <div class="form-group text-center">{{ __('Necesitarás ponerte en contacto con nosotros para obtener detalles de acceso temporales:') }} <b>{{ env('MAIL_ADDRESS_CONTACT') }}</b></div>
          <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Usuario') }}</label>

                <div class="col-md-8">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                <div class="col-md-8">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Ingresar') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
