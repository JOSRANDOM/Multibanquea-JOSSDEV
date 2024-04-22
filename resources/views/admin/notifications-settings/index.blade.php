@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Configuración de notificaciones</h1>
</div>
@if (session('status'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('status') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<div class="card mb-4">
    <div class="card-header">
        INFORMACIÓN
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.notifications_settings.save') }}" class="row g-4" enctype='multipart/form-data' >
        {{ csrf_field() }}
            <h3>Configuración general de las notificaciones</h3>
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Imagen de Cabecera</label>
                    <input class="form-control" type="file" id="image">
                </div>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="col-lg-12">
                <div class="form-floating mb-3">
                    {{-- <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"> --}}
                    <textarea name="" id="" cols="30" rows="10" class="form-control" style="height: 200px" ></textarea>
                    <label for="floatingInput">Pie de notificaion</label>
                </div>
            </div>
            <h3>Usuarios nuevos</h3>
            <div class="col-lg-12">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="ingrese un numero valido" min="0" step="1" value="48">
                    <label for="floatingInput">Horas antes de vencer</label>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-floating mb-3">
                    {{-- <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"> --}}
                    <textarea name="" id="" cols="30" rows="10" class="form-control" style="height: 200px" ></textarea>
                    <label for="floatingInput">Cuerpo de mensaje</label>
                </div>
            </div>
            <h3>Usuarios por vencer</h3>
            <div class="col-lg-12">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="floatingInput" placeholder="ingrese un numero valido" min="0" step="1" value="48">
                    <label for="floatingInput">Horas antes de vencer</label>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-floating mb-3">
                    {{-- <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"> --}}
                    <textarea name="" id="" cols="30" rows="10" class="form-control" style="height: 200px" ></textarea>
                    <label for="floatingInput">Cuerpo de mensaje</label>
                </div>
            </div>
            <div class="col-lg-12 text-center">
                <button class="w-50 btn btn-primary">GUARDAR</button>
            </div>
        </form>
    </div>
</div>
@endsection
