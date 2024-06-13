@extends('layouts.app')

@section('content')
<!-- Modal para seleccionar intervalo de 30 minutos -->
<div class="modal fade" id="trainingTimeModal" tabindex="-1" aria-labelledby="trainingTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trainingTimeModalLabel">Seleccionar Tiempo de Entrenamiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="trainingTime" class="form-label">Seleccione el tiempo de entrenamiento:</label>
                    <select class="form-select" id="trainingTime">
                        <option value="30">30 minutos</option>
                        <option value="60">1 hora</option>
                        <option value="90">1 hora 30 minutos</option>
                        <option value="120">2 horas</option>
                        <!-- Agrega más opciones según sea necesario -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="confirmTrainingTimeBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 style="color: white;">ENTRENAMIENTO <span class="badge bg-warning text-dark">beta</span></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="btn btn-danger">
                <i class="bi bi-arrow-return-left rounded"></i> Regresar
            </a>
        </div>
    </div>
</div>

<div class="d-flex align-items-center mb-3">
    <div id="trainingTimeDisplay" class="badge bg-warning text-dark me-3" style="font-size: 1.25rem;">
        <i class="bi bi-hourglass-split"></i> Tiempo restante: <span id="timeRemaining"></span>
    </div>
    <div id="questionCounter" class="badge bg-warning text-dark" style="font-size: 1.25rem;">
        Preguntas respondidas: <span id="answeredCount">0</span> / <span id="totalQuestions">0</span>
    </div>
</div>

<div id="question-container">
    @foreach($subcategories as $subcategory)
        @foreach($subcategory->questions as $question)
        <div class="question-item" data-question-id="{{ $question->id }}" style="display: none;">
            <li class="p-3 mb-3 rounded" style="background-color: white;">
                <h4 class="mb-4">{{ $question->text }}</h4> <!-- Añadido margin-bottom para separar la pregunta de las respuestas -->
                <div class="answer-list">
                    @foreach($question->answers as $answer)
                    <button type="button" class="btn btn-primary mb-3 rounded answer-btn w-100" data-correct="{{ $answer->correct }}" data-text="{{ $answer->text }}" data-question-id="{{ $question->id }}">{{ $answer->text }}</button>
                    @endforeach
                </div>
                <div class="correct-answer mt-2" style="display: none;">
                    <span class="badge bg-success correct-answer-label" style="font-size: 1.25rem;">La respuesta correcta es: <strong class="correct-answer-text"></strong></span>
                </div>
            </li>
        </div>
        @endforeach
    @endforeach
</div>

<!-- Modal para mostrar cuando el tiempo de entrenamiento ha terminado -->
<div class="modal fade" id="trainingFinishedModal" tabindex="-1" aria-labelledby="trainingFinishedModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="trainingFinishedModalLabel">¡Tiempo de Entrenamiento Culminado!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>El tiempo de entrenamiento ha terminado. Serás redirigido a la página de inicio.</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('inline_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#trainingTimeModal').modal('show');

        const answerButtons = document.querySelectorAll('.answer-btn');
        let countdownTimer;
        let countdownSeconds;
        let currentQuestionIndex = 0;
        let answeredCount = 0;
        const questions = document.querySelectorAll('.question-item');
        const totalQuestions = questions.length;

        document.getElementById('totalQuestions').textContent = totalQuestions;

        function showNextQuestion() {
            if (currentQuestionIndex < questions.length) {
                if (currentQuestionIndex > 0) {
                    questions[currentQuestionIndex - 1].style.display = 'none';
                }
                questions[currentQuestionIndex].style.display = 'block';
                currentQuestionIndex++;
            }
        }

        answerButtons.forEach(button => {
            button.addEventListener('click', function() {
                const isCorrect = this.getAttribute('data-correct') === '1';
                const answerText = this.getAttribute('data-text');
                const correctAnswerElement = this.parentElement.nextElementSibling.querySelector('.correct-answer-text');
                const questionId = this.getAttribute('data-question-id');

                if (isCorrect) {
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    correctAnswerElement.textContent = answerText;
                } else {
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-danger');
                    const correctAnswer = Array.from(this.parentElement.children).find(btn => btn.getAttribute('data-correct') === '1');
                    correctAnswerElement.textContent = correctAnswer.getAttribute('data-text');
                }

                this.parentElement.nextElementSibling.style.display = 'block';

                this.parentElement.querySelectorAll('.answer-btn').forEach(btn => btn.disabled = true);

                answeredCount++;
                document.getElementById('answeredCount').textContent = answeredCount;

                setTimeout(showNextQuestion, 2000);
            });
        });

        document.getElementById('confirmTrainingTimeBtn').addEventListener('click', function() {
            const selectedTime = document.getElementById('trainingTime').value;
            if (selectedTime.trim() !== '') {
                countdownSeconds = selectedTime * 60;
                startCountdown();
                const hours = selectedTime / 60;
                document.getElementById('trainingTimeDisplay').innerHTML = `<i class="bi bi-hourglass-split"></i> Tiempo restante: <span id="timeRemaining">${selectedTime} minutos (${hours} horas)</span>`;
                $('#trainingTimeModal').modal('hide');
                showNextQuestion();
            } else {
                alert('Por favor, seleccione el tiempo de entrenamiento.');
            }
        });

        function startCountdown() {
            countdownTimer = setInterval(function() {
                countdownSeconds--;
                const minutes = Math.floor(countdownSeconds / 60);
                const seconds = countdownSeconds % 60;
                document.getElementById('timeRemaining').textContent = `${minutes} : ${seconds}`;

                if (countdownSeconds <= 0) {
                    clearInterval(countdownTimer);
                    $('#trainingFinishedModal').modal('show');
                    setTimeout(function() {
                        window.location.href = "{{ route('home') }}";
                    }, 3000);
                }
            }, 1000);
        }
    });
</script>
@endsection
