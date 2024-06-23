@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 style="color: white;">ENTRENAMIENTO</h1>
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
        Preguntas respondidas: <span id="answeredCount">0</span> / <span id="totalQuestions">0</span>
    </div>
</div>

<div id="question-container">
    @foreach($subcategories as $subcategory)
        @foreach($subcategory->questions as $question)
        <div class="question-item" data-question-id="{{ $question->id }}" style="display: none;">
            <li class="p-3 mb-3 rounded" style="background-color: white;">
                <p class="mb-4">{{ $question->text }}</p>
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

                answeredCount++;
                document.getElementById('answeredCount').textContent = answeredCount;

                setTimeout(showNextQuestion, 2000);
            });
        });

        showNextQuestion();
    });
</script>
@endsection
