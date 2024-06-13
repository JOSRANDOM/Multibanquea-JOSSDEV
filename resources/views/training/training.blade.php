@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
    <h1 style="color: white;">ENTRENAMIENTO <span class="badge bg-warning text-dark">beta</span></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="btn btn-danger">
                <i class="bi bi-arrow-return-left rounded"></i> Regresar
            </a>
        </div>
    </div>
</div>

@foreach($subcategories as $subcategory)
        @foreach($subcategory->questions as $question)
        <li class="p-3 mb-3 rounded" style="background-color: white;">
            <h4>{{ $question->text }}</h4>
            <div class="btn-group">
                @foreach($question->answers as $answer)
                <button type="button" class="btn btn-primary mx-1 rounded answer-btn" data-correct="{{ $answer->correct }}" data-text="{{ $answer->text }}">{{ $answer->text }}</button>
                @endforeach
            </div>
            <div class="correct-answer" style="display: none;">
                La respuesta correcta es: <span class="correct-answer-text"></span>
            </div>
        </li>
        @endforeach
@endforeach

@endsection

@section('inline_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const answerButtons = document.querySelectorAll('.answer-btn');

        answerButtons.forEach(button => {
            button.addEventListener('click', function() {
                const isCorrect = this.getAttribute('data-correct');
                const correctAnswerText = this.getAttribute('data-text');

                if (isCorrect == 0) {
                    const correctAnswerElement = this.parentElement.nextElementSibling.querySelector('.correct-answer-text');
                    correctAnswerElement.textContent = correctAnswerText;
                    this.parentElement.nextElementSibling.style.display = 'block';
                }
            });
        });
    });
</script>
@endsection
