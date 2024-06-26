@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h4 m-0 text-white w-100">ENTRENAMIENTO - Pregunta {{ $currentQuestionIndex }}/{{ $totalQuestions }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="btn btn-danger btn-sm float-end"><i class="bi bi-arrow-return-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 col-xl-7">
        <div class="card shadow mb-4 overflow-hidden" onselectstart="return false" ondragstart="return false">
            <div class="card-body animate__animated animate__bounceInUp">
                <div class="fs-5 mb-4">
                    {{ $question->text }}
                </div>
                    @foreach($question->answers as $answer)
                        <div class="mb-4">
                            <button type="button" class="d-flex align-items-center btn p-3 mb-3 w-100 text-start btn-outline-dark shadow">
                                <div class="me-3">
                                </div>
                                <li class="fal fa-fw fa-square" data-correct="{{ $answer->correct }}">
                                    {{ $answer->text }}
                                </li>
                            </button>
                        </div>
                    @endforeach
                    <div class="w-100">
                        <button disabled="disabled" type="button" class="btn btn-lg btn-primary">Confirmar respuesta</button>
                        <button type="button" class="btn btn-lg btn-danger float-end ">Saltar Pregunta</button>
                    </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-5">
                   <!-- Card de Detalles del Entrenamiento -->
        <div class="card bg-dark text-white mb-4">
            <div class="card-body">
                <h5 class="card-title">Detalles del Entrenamiento</h5>
                <p class="card-text">Entrenamiento de: {{ $trainingTitle }}</p>
                <p class="card-text">Número de preguntas: {{ $totalQuestions }}</p>
                <p class="card-text">Fecha: {{ \Carbon\Carbon::now()->format('d-m-Y') }}</p>
                <p class="card-text" id="progress-text">Has respondido 0% (0) de las preguntas del examen.</p>
                    <div class="progress">
                        <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
            </div>
        </div>
                <!-- Segunda Card -->
        <div class="card bg-dark text-white mb-4">
            <div class="card-body">
                <h5 class="card-title">Queremos saber tu opinión sobre el entrenamiento</h5>
                <p class="card-text">Por favor, comparte tus comentarios a continuación:</p>
                <textarea class="form-control" rows="5" placeholder="Escribe tus comentarios aquí..."></textarea>
            </div>
        </div>
    </div>
</div>

@endsection

@section('inline_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const answerButtons = document.querySelectorAll('.list-group-item');
        
        answerButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Obtener si la respuesta es correcta
                const isCorrect = this.getAttribute('data-correct') === '1';
                alert(isCorrect ? 'Respuesta correcta' : 'Respuesta incorrecta');
            });
        });
    });
</script>
@endsection
