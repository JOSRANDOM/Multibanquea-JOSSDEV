@extends('layouts.app')

@section('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
        <h1 style="color: white;">HORARIO DE ENTRENAMIENTO</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('home') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-return-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>
    <div class="calendar-container"> <!-- Contenedor adicional para el calendario -->
        <div id="calendar"></div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selecciona los días que quieres entrenar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body" aria-labelledby="exampleModalLabel">
                <!-- Contenido de los botones de los días de la semana -->
                <div class="container">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-1 pb-1 mb-1" aria-labelledby="exampleModalLabel">
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('lunes')">Lunes</button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('martes')">Martes</button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('miércoles')">Miércoles</button>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-1 pb-1 mb-1" aria-labelledby="exampleModalLabel">
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('jueves')">Jueves</button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('viernes')">Viernes</button>
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('sábado')">Sábado</button>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-1 pb-1 mb-1" aria-labelledby="exampleModalLabel">
                        <button type="button" class="btn btn-secondary btn-lg" onclick="selectDay('domingo')">Domingo</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    
@endsection

@section('inline_scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.js'></script>

<script>

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        themeSystem: 'bootstrap', // Utilizamos el tema Bootstrap por defecto
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        eventColor: 'blue', // Cambiamos el color de los eventos a azul
        backgroundColor: 'lightgray', // Cambiamos el color de fondo del calendario a gris claro
        
    });
    calendar.render();
});

function selectDay(day) {
        // Reiniciar todos los botones a su estado predeterminado
        var buttons = document.querySelectorAll('.btn-group button');
        buttons.forEach(function(button) {
            button.classList.remove('btn-primary');
            button.classList.add('btn-secondary');
        });
        
        // Marcar como seleccionado el botón del día seleccionado
        var selectedButton = document.querySelector('.btn-group button[data-day="' + day + '"]');
        selectedButton.classList.remove('btn-secondary');
        selectedButton.classList.add('btn-primary');
    }
    

document.addEventListener('DOMContentLoaded', function() {
        var response = @json($response); // Convertir la respuesta de PHP a JavaScript
        
        // Verificar si hay una respuesta válida
        if (response) {
            // Mostrar la respuesta en una ventana modal
            $('#myModal').modal('show');
            
            // Actualizar el contenido de la ventana modal con la respuesta
            $('#modal-body').html(response['response']);
        }
    });

</script>
@endsection
