@extends('layouts.app')

@section('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
<link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container pt-3 pb-2 mb-3 ">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
        <h1 style="color: white;">ENTRENAMIENTO: {{ request()->query('categoryName') }} <span class="badge bg-warning text-dark">beta</span></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-success" id="newScheduleBtn">
                    <i class="bi bi-plus"></i> Nuevo Horario
                 </button>
                <a href="{{ route('home') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-return-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>
    <div class="event-details">
        <h2>Detalles del Evento</h2>
        <p>Nombre de la categoría: {{ request()->query('categoryName') }}</p>
        <p>ID de la categoría: {{ request()->query('categoryId') }}</p> <!-- Agregar esta línea para mostrar el ID de la categoría -->
    </div>
</div>
@endsection
