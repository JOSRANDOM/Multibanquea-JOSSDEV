@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 style="color: white;">ENTRENAMIENTO</h1>
    <div class="badge bg-info text-dark" style="font-size: 1.25rem;">
        Fecha seleccionada: {{ $fecha }}
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="btn btn-danger">
                <i class="bi bi-arrow-return-left rounded"></i> Regresar
            </a>
        </div>
    </div>
</div>

<div class="d-flex align-items-center mb-3">
    <div id="questionCounter" class="badge bg-warning text-dark" style="font-size: 1.25rem;">
        Preguntas respondidas: <span id="answeredCount">0</span> / <span id="totalQuestions">{{ $totalQuestions }}</span>
    </div>
</div>

<div id="question-container">
    @foreach($subcategories as $subcategory)
        @foreach($subcategory->questions as $index => $question)
        <div class="question-item" data-question-id="{{ $question->id }}" style="display: none;">
            <li class="p-3 mb-3 rounded" style="background-color: white; border: 1px solid black;">
                <p class="mb-4">{{ $question->text }}</p>
                <div class="answer-list">
                    @foreach($question->answers as $answer)
                    <button type="button" class="btn mb-3 rounded answer-btn w-100"
                            data-question-id="{{ $question->id }}"
                            data-answer-id="{{ $answer->id }}"
                            data-correct="{{ $answer->correct }}"
                            data-text="{{ $answer->text }}"
                            style="border: 2px solid black; border-radius: 5px;">
                        {{ $answer->text }}
                    </button>
                    @endforeach
                </div>
                <div class="correct-answer mt-2" style="display: none;">
                    <span class="badge bg-success correct-answer-label"
                          style="font-size: 1.5rem; background-color: lightgreen; display: inline-block; max-width: 100%; word-wrap: break-word;">
                        La respuesta correcta es: <strong class="correct-answer-text"></strong>
                    </span>
                </div>
            </li>
        </div>
        @endforeach
    @endforeach
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

        if (currentQuestionIndex === totalQuestions) {
            // Mostrar el modal al finalizar
            $('#finishTrainingModal').modal('show');
        }
    }

    answerButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isCorrect = this.getAttribute('data-correct') === '1';
            const answerText = this.getAttribute('data-text');
            const correctAnswerElement = this.parentElement.nextElementSibling.querySelector('.correct-answer-text');

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

            // Almacenar la respuesta usando AJAX
            const questionId = this.getAttribute('data-question-id');
            const answerId = this.getAttribute('data-answer-id');
            const isCorrectValue = isCorrect ? 1 : 0;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route('training.storeAnswer') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    user_id: {{ Auth::id() }},
                    question_id: questionId,
                    answer_id: answerId,
                    is_correct: isCorrectValue,
                    date: '{{ $fecha }}' // Asegúrate de que $fecha esté definido en tu vista
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al almacenar la respuesta.');
                }
                return response.json();
            })
            .then(data => {
                console.log('Respuesta del servidor:', data);
                answeredCount++;
                document.getElementById('answeredCount').textContent = answeredCount;
                setTimeout(showNextQuestion, 2000); // Avanzar a la siguiente pregunta después de 2 segundos
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                // Manejar el error si es necesario
            });

        });
    });

    // Al finalizar el entrenamiento, redirigir a training.statistics
    $('#finishTrainingModal').on('hidden.bs.modal', function (e) {
        window.location.href = '{{ route('training.statistics') }}';
    });

    showNextQuestion(); // Mostrar la primera pregunta al cargar la página
});

</script>
@endsection
