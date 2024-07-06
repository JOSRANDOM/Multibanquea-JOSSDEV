<!-- training/index.blade.php -->

@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
        <div class="custom-container">
            <div class="text-center">
                <h1 style="color: black;">¡Descubre cómo nuestra IA puede transformar tu aprendizaje!</h1>
            </div>

            <div class="container">
                <div class="text-center">
                    <h1>¡En solo 3 pasos!</h1>
                </div>
                
                <div class="modal-body text-center">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="circle" data-step="1">
                            <div class="inner-circle"></div>
                            <dotlottie-player 
                                src="https://lottie.host/f99546d9-f31e-4095-b29e-5a4cb5245f4d/lFvgJghGuM.json" 
                                background="transparent" 
                                speed="1" 
                                style="width: 100px; height: 100px;" 
                                loop 
                                autoplay>
                            </dotlottie-player>
                        </div>
                        <div class="arrow">
                            <i class="bi bi-caret-right-fill"></i>
                        </div>
                        <div class="circle" data-step="2">
                            <div class="inner-circle"></div>
                            <dotlottie-player 
                                src="https://lottie.host/cfcb36e4-33ec-40aa-8913-0977e5fa9d39/yOqcQm0FKO.json" 
                                background="transparent" 
                                speed="1" 
                                style="width: 100px; height: 100px;" 
                                loop 
                                autoplay>
                            </dotlottie-player>
                        </div>
                        <div class="arrow">
                            <i class="bi bi-caret-right-fill"></i>
                        </div>
                        <div class="circle" data-step="3">
                            <div class="inner-circle"></div>
                            <dotlottie-player 
                                src="https://lottie.host/24626ee2-7ed9-4abb-a356-8c2c6f820f2e/z7N1XgJtlC.json" 
                                background="transparent" 
                                speed="1" 
                                style="width: 100px; height: 100px;" 
                                loop 
                                autoplay>
                            </dotlottie-player>
                        </div>
                    </div>
                    <div id="mensajePaso" class="mt-3"></div>
                </div>
            </div>

            <div class="text-center">
                <p>Prepárate para el éxito en tus exámenes con nuestra avanzada plataforma de inteligencia artificial. Nuestro algoritmo utiliza las mejores prácticas educativas como la repetición espaciada, segmentación de áreas de estudio y flashcards. Practica eficazmente y prepárate completamente para el examen.</p>
            </div>

            <div class="text-center my-4">
                <!-- Determinar el texto del botón -->
                @if ($step1Completed)
                    <form action="{{ route('training.start_balanced') }}" method="POST">
                        @csrf
                        <input type="hidden" name="exam_id" value="1"> <!-- Ajusta el valor del exam_id según tu lógica -->
                        <button type="submit" class="btn btn-primary">Continuar Clasificación</button>
                    </form>
                @else
                    <form action="{{ route('training.start_balanced') }}" method="POST">
                        @csrf
                        <input type="hidden" name="exam_id" value="1"> <!-- Ajusta el valor del exam_id según tu lógica -->
                        <button type="submit" class="btn btn-primary">Empezar</button>
                    </form>
                @endif
            </div>
                        
        </div>
    </div>
</div>
@endsection

@section('inline_scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var lottieElements = document.querySelectorAll('.dotlottie-player');
        var mensajePasoElement = document.getElementById('mensajePaso');

        lottieElements.forEach(function(element) {
            element.addEventListener('click', function() {
                var animationPath = element.getAttribute('src');

                var mensaje;
                switch (animationPath) {
                    case 'https://lottie.host/f99546d9-f31e-4095-b29e-5a4cb5245f4d/lFvgJghGuM.json':
                        mensaje = 'Examen de clasificación de 150 preguntas - fase 1';
                        break;
                    case 'https://lottie.host/cfcb36e4-33ec-40aa-8913-0977e5fa9d39/yOqcQm0FKO.json':
                        mensaje = 'Examen de clasificación de 150 preguntas - fase 2';
                        break;
                    case 'https://lottie.host/24626ee2-7ed9-4abb-a356-8c2c6f820f2e/z7N1XgJtlC.json':
                        mensaje = 'Arma tu calendario de entrenamiento';
                        break;
                    default:
                        mensaje = 'Paso desconocido';
                        break;
                }

                mensajePasoElement.textContent = mensaje;
            });
        });
    });
</script>
@endsection
