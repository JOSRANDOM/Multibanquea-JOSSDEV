@extends('layouts.front')

@section('content')
<div class="container p-5">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 mb-5 p-5">
            <div class="card">
                <div class="card-header">{{ __('Restablecer Contraseña') }}</div>

                <div class="text-center p-5"> <!-- Contenedor para centrar los elementos -->
                    <div class="mb-3">
                        <img src="{{ asset('/img/brand/' . config('variant.name') . '/logo-color-300.png') }}" alt="{{ config('app.name') }}" style="width: 50%; height: auto;">
                    </div>

                    <div class="mb-3">
                        <p class="">
                            Para restablecer tu contraseña por favor ingresa tu correo estudiantil, 
                        </p>
                        <p class="">
                            "se te enviará un correo para restablecer tu contraseña"
                        </p>
                    </div>
                </div>

                <div class="card-body mb-5 p-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row p-5">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo Electrónico') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-5">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Enviar correo') }}
                            </button>
                        </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
