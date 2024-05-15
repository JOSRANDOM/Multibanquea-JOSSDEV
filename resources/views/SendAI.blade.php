<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Categorías</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' rel='stylesheet' />
</head>
<body>
    <h1>Calendario de Categorías</h1>

    <div id='calendar'></div>

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
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script>
            var selectedDay = null; // Variable para almacenar el día seleccionado

        function highlightButton(button) {
            $(button).toggleClass('active');
            selectedDay = $(button).text(); // Almacenar el día seleccionado
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

        // Cuando se haga clic en "Programar"
        $('#daysModal button.btn-primary').click(function() {
            // Obtener días seleccionados
            var selectedDays = [];
            $('#daysModal .btn.active').each(function() {
                selectedDays.push($(this).text());
            });

            // Obtener categorías
            var categories = [];
            @foreach ($response->json() as $item)
                @if ($item['nota'] < 10)
                    categories.push('{{ DB::table('question_categories')->where('id', $item['categoria'])->value('name') }}');
                @endif
            @endforeach

            // Distribuir las categorías entre los días seleccionados
            var events = [];
            for (var i = 0; i < categories.length; i++) {
                var selectedDay = selectedDays[i % selectedDays.length]; // Ciclo entre los días seleccionados
                var currentDate = moment().startOf('month').day(selectedDay); // Obtener la fecha del primer día del mes correspondiente al día seleccionado
                var eventDate = currentDate.add(Math.floor(i / selectedDays.length), 'weeks').format("YYYY-MM-DD"); // Agregar semanas según el índice

                events.push({
                    title: categories[i],
                    start: eventDate,
                    allDay: true
                });
            }

            // Agregar eventos al calendario
            calendar.addEventSource(events);
        });

    });
    </script>
</body>
</html>
