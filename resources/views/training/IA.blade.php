@extends('layouts.app')

@section('styles')
<link href="{{ asset('/css/calendar.css') }}" rel="stylesheet">
<link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' rel='stylesheet' />
@endsection

@section('content')
<div class="container pt-3 pb-2 mb-3 ">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-boton">
        <h1 style="color: white;">HORARIO DE ENTRENAMIENTO <span class="badge bg-warning text-dark">beta</span></h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('home') }}" class="btn btn-danger">
                    <i class="bi bi-arrow-return-left"></i> Regresar
                </a>
            </div>
        </div>
    </div>
 <span id="selectedDays"></span>

    <div class="calendar-container"> <!-- Contenedor adicional para el calendario -->
        <div id="calendar"></div>
    </div>

<!-- Ventana emergente con botones para los días de la semana -->
<div class="modal fade" id="daysModal" tabindex="-1" aria-labelledby="daysModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="daysModalLabel">Seleccione un día</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="btn-group" role="group" aria-label="Días de la semana">
                    <button type="button" class="btn btn-primary" id="lunesBtn" onclick="highlightButton(this)">Lunes</button>
                    <button type="button" class="btn btn-primary" id="martesBtn" onclick="highlightButton(this)">Martes</button>
                    <button type="button" class="btn btn-primary" id="miercolesBtn" onclick="highlightButton(this)">Miércoles</button>
                    <button type="button" class="btn btn-primary" id="juevesBtn" onclick="highlightButton(this)">Jueves</button>
                    <button type="button" class="btn btn-primary" id="viernesBtn" onclick="highlightButton(this)">Viernes</button>
                    <button type="button" class="btn btn-primary" id="sabadoBtn" onclick="highlightButton(this)">Sábado</button>
                    <button type="button" class="btn btn-primary" id="domingoBtn" onclick="highlightButton(this)">Domingo</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="scheduleBtn">Programar</button>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

@section('inline_scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
        var selectedDay = null; // Variable para almacenar el día seleccionado

        function highlightButton(button) {
        $(button).toggleClass('active');
        selectedDay = $(button).text(); // Almacenar el día seleccionado

        // Obtener los días seleccionados y mostrarlos junto al título del calendario
        var selectedDays = [];
        $('#daysModal .btn.active').each(function() {
            selectedDays.push($(this).text());
        });
        $('#selectedDays').text('(' + selectedDays.join(', ') + ')');
    }


    document.addEventListener('DOMContentLoaded', function() {
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    events: [] // Inicialmente, no hay eventos
});
calendar.render();

// Mostrar la ventana emergente al hacer clic en el botón de días de la semana
$('#daysModal').modal('show');

$('#scheduleBtn').click(function() {
console.log("Botón 'Programar' presionado");

// Obtener días seleccionados
var selectedDays = [];
$('#daysModal .btn.active').each(function() {
    selectedDays.push($(this).text());
});
console.log("Días seleccionados:", selectedDays);

// Obtener categorías
var categories = [];
@foreach ($response->json() as $item)
    @if ($item['nota'] < 10)
        categories.push('{{ DB::table('question_categories')->where('id', $item['categoria'])->value('name') }}');
    @endif
@endforeach
console.log("Categorías:", categories);

    // Mapeo de nombres de días en inglés a español
    var daysMapping = {
        "Monday": "Lunes",
        "Tuesday": "Martes",
        "Wednesday": "Miércoles",
        "Thursday": "Jueves",
        "Friday": "Viernes",
        "Saturday": "Sábado",
        "Sunday": "Domingo"
    };

    // Distribuir las categorías solo en los días seleccionados
    var events = [];
    var currentDate = moment().startOf('month');
    while (currentDate.month() == moment().month()) {
var dayName = daysMapping[currentDate.format('dddd')]; // Obtener el nombre del día en español
if (selectedDays.includes(dayName)) {
    // Elegir una categoría aleatoria
    var randomCategory = categories[Math.floor(Math.random() * categories.length)];

    events.push({
        title: randomCategory,
        start: currentDate.format("YYYY-MM-DD"),
        allDay: true
    });
}
currentDate.add(1, 'day');
}

    console.log("Eventos a agregar:", events);
        // Agregar eventos al calendario
        calendar.addEventSource(events);

        $('#daysModal').modal('hide');
    });

    });

</script>
@endsection

