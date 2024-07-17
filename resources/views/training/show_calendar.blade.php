@extends('layouts.app')

@section('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
<link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container pt-3 pb-2 mb-3">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 style="color: white;">HORARIO DE ENTRENAMIENTO</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('home') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-return-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>

    <div class="calendar-container">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('inline_scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            events: [
                @foreach($trainings as $training)
                {
                    title: '{{ DB::table('question_categories')->where('id', $training->id_category)->value('name') }}',
                    start: '{{ $training->date_training }}',
                    allDay: true,
                    extendedProps: {
                        categoryId: '{{ $training->id_category }}'
                    }
                },
                @endforeach
            ],
            eventColor: '#01897B',
            eventTextColor: 'white',
            eventClick: function(info) {
                var categoryId = info.event.extendedProps.categoryId;
                var fechaSeleccionada = info.event.startStr; // Aquí obtienes la fecha seleccionada del evento

                // Construyes la URL de la ruta 'training' con ambos parámetros
                var trainingRoute = "{{ route('training.training', ['id' => ':id', 'fecha' => ':fecha']) }}";
                trainingRoute = trainingRoute.replace(':id', categoryId);
                trainingRoute = trainingRoute.replace(':fecha', fechaSeleccionada);

                // Rediriges a la página de entrenamiento con los parámetros incluidos
                window.location.href = trainingRoute;
            }
        });
        calendar.render();
    });
</script>
@endsection
