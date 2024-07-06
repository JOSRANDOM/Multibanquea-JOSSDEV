@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h4 m-0 text-white w-100">EMPECEMOS TU ENTRENAMIENTO</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('training.display') }}" class="btn btn-danger btn-sm float-end">
                <i class="bi bi-arrow-return-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Card 1: Examen de Clasificación Fase 1 -->
        <div class="col-12 mb-4">
            <div class="card position-relative">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">
                        Examen de Clasificación Fase 1
                        <div>
                            <span class="badge bg-warning text-dark"><i class="bi bi-question-octagon"></i> Pendiente</span>
                            <span class="badge bg-success text-white"><i class="bi bi-info-circle"></i></span>
                        </div>
                    </h5>
                    <p>Examen de 180 preguntas</p>
                    <a href="" class="btn btn-primary">Empezar</a>
                </div>
            </div>
        </div>
        <!-- Card 2: Examen de Clasificación Fase 2 -->
        <div class="col-12 mb-4">
            <div class="card position-relative">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">
                        Examen de Clasificación Fase 2
                        <div>
                            <span class="badge bg-warning text-dark"><i class="bi bi-question-octagon"></i> Pendiente</span>
                            <span class="badge bg-success text-white"><i class="bi bi-info-circle"></i></span>
                        </div>
                    </h5>
                    <p>Examen de 180 preguntas</p>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#fase1Modal" disabled>Empezar</button>
                </div>
            </div>
        </div>
        <!-- Card 3: Calendario de Entrenamiento -->
        <div class="col-12 mb-4">
            <div class="card position-relative">
                <div class="card-body">
                    <h5 class="card-title d-flex justify-content-between">
                        Calendario de Entrenamiento
                        <div>
                            <span class="badge bg-warning text-dark"><i class="bi bi-question-octagon"></i> Pendiente</span>
                            <span class="badge bg-success text-white"><i class="bi bi-info-circle"></i></span>
                        </div>
                    </h5>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#fase2Modal" disabled>Empezar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Fase 1 -->
<div class="modal fade" id="fase1Modal" tabindex="-1" aria-labelledby="fase1ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fase1ModalLabel">Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Primero debes hacer el examen clasificatorio - Fase 1.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Fase 2 -->
<div class="modal fade" id="fase2Modal" tabindex="-1" aria-labelledby="fase2ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fase2ModalLabel">Información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Primero debes resolver el examen clasificatorio - Fase 2.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection
