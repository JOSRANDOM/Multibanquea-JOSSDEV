<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario de Categorías</title>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css' rel='stylesheet' />
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js'></script>
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
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Lunes</button>
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Martes</button>
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Miércoles</button>
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Jueves</button>
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Viernes</button>
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Sábado</button>
                        <button type="button" class="btn btn-primary" onclick="highlightButton(this)">Domingo</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Programar</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/locales/es.js'></script>
    <script>
        function highlightButton(button) {
            $(button).toggleClass('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: [
                    @foreach ($response->json() as $item)
                        @if ($item['nota'] < 10)
                            {
                                title: '{{ DB::table('question_categories')->where('id', $item['categoria'])->value('name') }}',
                                start: '{{ now()->addDays(rand(1, 30))->format("Y-m-d") }}',
                                allDay: true
                            },
                        @endif
                    @endforeach
                ]
            });
            calendar.render();

            // Mostrar la ventana emergente al hacer clic en el botón de días de la semana
            $('#daysModal').modal('show');
        });
    </script>
</body>
</html>
