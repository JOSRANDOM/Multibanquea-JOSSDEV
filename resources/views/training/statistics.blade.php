@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 style="color: white;">ESTADÍSTICAS DEL ENTRENAMIENTO</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="btn btn-danger">
                <i class="bi bi-arrow-return-left rounded"></i> Regresar
            </a>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            @php
                // Formatear la fecha del entrenamiento
                $formattedDate = \Carbon\Carbon::parse($date)->format('d/m/Y');

                // Calcular el porcentaje de preguntas correctas e incorrectas
                $totalQuestions = $correctCount + $incorrectCount;
                $correctPercentage = $totalQuestions > 0 ? ($correctCount / $totalQuestions) * 100 : 0;
                $incorrectPercentage = $totalQuestions > 0 ? ($incorrectCount / $totalQuestions) * 100 : 0;
            @endphp

            <h5 class="card-title">Entrenamiento - {{ $formattedDate }}</h5>

            <!-- Título del progreso del entrenamiento -->
            <h6 class="card-subtitle mb-2 text-muted">Progreso del entrenamiento</h6>

            <!-- Barra de progreso -->
            <div class="progress mt-3 mb-3">
                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $correctPercentage }}%;" aria-valuenow="{{ $correctPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($correctPercentage, 2) }}%</div>
                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $incorrectPercentage }}%;" aria-valuenow="{{ $incorrectPercentage }}" aria-valuemin="0" aria-valuemax="100">{{ number_format($incorrectPercentage, 2) }}%</div>
            </div>


            <p class="card-text">Preguntas correctas: {{ $correctCount }}</p>
            <p class="card-text">Preguntas incorrectas: {{ $incorrectCount }}</p>

        </div>
    </div>
</div>

@endsection
