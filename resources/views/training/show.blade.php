@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h4 m-0 text-white w-100">ENTRENAMIENTO - Pregunta {{ $currentQuestionIndex }}/{{ $totalQuestions }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('home') }}" class="bbtn btn-danger btn-sm float-end"><i class="bi bi-arrow-return-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-lg-6 col-xl-7">
        <div class="card">
            <div class="card-header">
                Examen estándar de {{ $totalQuestions }} preguntas
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $question->text }}</h5>
                <ul class="list-group">
                    @foreach($question->answers as $answer)
                        <li class="list-group-item" data-correct="{{ $answer->correct }}">
                            {{ $answer->text }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 col-xl-5"></div>
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
