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
                    <div class="mb-4">Este ingreso es exclusivo para Estudiantes de Institutos/Universidades que tienen convenio con nosotros.</div>

                    <form method="post" action="{{ route('login.custom') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    
                        <div class="form-group form-floating mb-3">
                            <input type="text" class="form-control" name="study_id" id="study_id" placeholder="Username" required="required" autofocus>
                            <label for="floatingName">ID de Estudiante</label>
                        </div>
                    
                        <div class="form-group form-floating mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required="required">
                            <label for="floatingPassword">Contraseña</label>
                        </div>
                    
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                    
                        <div class="mt-3 text-center">
                            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>
                    

                </div>
            </div>
            <div class="col-6 bg-primary d-none d-md-flex auth-img-login">
            </div>
        </div>
    </div>
@endsection
