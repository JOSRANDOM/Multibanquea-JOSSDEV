@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 style="color: white;">Paso 1/3 - Examen de clasificación fase 1</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="btn btn-danger">
                <i class="bi bi-arrow-return-left rounded"></i> Regresar
            </a>
        </div>
    </div>
</div>

<div id="question-container">
    <div class="row">
        <!-- Primera Columna -->
        <div class="col-12 col-lg-6 col-xl-7 order-lg-0">
            <ul class="list-unstyled">
                @php
                    $questionCounter = 1;
                @endphp
                @foreach($questions as $question)
                    <div class="card mb-4">
                        <ul class="list-group list-group-flush border-0">
                            <li class="list-group-item px-3 py-4 bg-light">
                                <div class="d-flex justify-content-between mb-3">
                                    <div class="text-muted small">Pregunta {{ $questionCounter++ }}</div>
                                    <div class="badge bg-warning text-dark fw-normal"><span><i class="bi bi-exclamation-circle"></i> Sin responder </span></div>
                                </div>
                                <div class="mb-3">
                                    <p>{{ $question->text }}</p>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <a href="{{ route('training.show', ['id' => $question->id]) }}" class="btn btn-sm btn-primary">Responder</a>
                                </div>
                                <div class="answer-list" style="display: none;">
                                    @foreach($question->answers as $answer)
                                        <button type="button" class="btn btn-primary mb-3 rounded answer-btn w-100" data-correct="{{ $answer->correct }}" data-text="{{ $answer->text }}" data-question-id="{{ $question->id }}">{{ $answer->text }}</button>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </ul>
        </div>

        <!-- Segunda Columna -->
        <div class="col-12 col-lg-6 col-xl-5 order-lg-1">
            <!-- Card de Detalles del Entrenamiento -->
            <div class="card bg-dark text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Detalles del Entrenamiento</h5>
                    <p class="card-text">Número de preguntas: {{ $totalQuestions }}</p>
                    <p class="card-text">Fecha: {{ $fecha }}</p>
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
</div>

<!-- Formulario oculto para enviar respuestas -->
<form id="answerForm" method="POST" action="{{ route('training.storeAnswer') }}" style="display: none;">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    <input type="hidden" name="date" value="{{ $fecha }}">
    <input type="hidden" name="question_id" id="questionIdInput">
    <input type="hidden" name="answer_id" id="answerIdInput">
    <input type="hidden" name="is_correct" id="isCorrectInput">
</form>

<!-- Modal para mostrar al finalizar el entrenamiento -->
<div class="modal fade" id="finishTrainingModal" tabindex="-1" aria-labelledby="finishTrainingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finishTrainingModalLabel">¡Entrenamiento finalizado!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¡Has completado todas las preguntas! ¡Buen trabajo!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('inline_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const answerButtons = document.querySelectorAll('.answer-btn');
        let currentQuestionIndex = 0;
        let answeredCount = 0;
        const totalQuestions = {{ $totalQuestions }};
        
        function updateProgressBar() {
            const progress = (answeredCount / totalQuestions) * 100;
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.textContent = Math.round(progress) + '%';
            progressText.textContent = `Has respondido ${Math.round(progress)}% (${answeredCount}) de las preguntas del examen.`;
        }

        answerButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.disabled = true;
                answeredCount++;
                document.getElementById('answeredCount').textContent = answeredCount;
                updateProgressBar();
                setTimeout(() => {
                    const questionCard = this.closest('.card');
                    questionCard.style.display = 'none';
                    showNextQuestion();
                }, 2000); // Retraso para mostrar la siguiente pregunta
            });
        });

        function showNextQuestion() {
            if (currentQuestionIndex < totalQuestions) {
                const questionCards = document.querySelectorAll('.card');
                questionCards[currentQuestionIndex].style.display = 'block';
                currentQuestionIndex++;
            }

            if (currentQuestionIndex === totalQuestions) {
                document.getElementById('finishTrainingBtnContainer').style.display = 'block';
            }
            questions[currentQuestionIndex].style.display = 'block';
            currentQuestionIndex++;
        }

        showNextQuestion();
    });

    showNextQuestion(); // Mostrar la primera pregunta al cargar la página
});

</script>
@endsection
