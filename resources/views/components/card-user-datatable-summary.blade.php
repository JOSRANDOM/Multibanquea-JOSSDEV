@section('inline_css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" /> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
{{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" /> --}}
@endsection
<div class="card mb-4">
    <div class="card-header">
        <h3 class="">Examenes (<span id="txt_fechas"></span>)
            <div class="btn-toolbar mb-2 mb-md-0 float-end">
                <button class="btn btn-sm btn-primary mx-1 " id="btnRangeDates"><i class="bi bi-calendar-plus"></i> Fechas</button>
            </div>
    </div>
    <div class="card-body">
        <div class="chart-lg">
            <canvas id="chart-user-exams-score-progress"></canvas>
        </div>
        <hr>
        <div class="table-responsive px-2">
            <table class="table table-striped table-hover table-sm" id="statsUser">
                <thead>
                    <tr>
                        <th class="text-center">FECHA</th>
                        <th class="text-center">TIPO EXAMEN</th>
                        <th class="text-center">PREGUNTAS</th>
                        <th class="text-center">DURACIÓN</th>
                        <th class="text-center">ACIERTOS</th>
                        <th class="text-center">FALLADOS</th>
                        <th class="text-center">PUNTUACIÓN</th>
                        <th class="text-center">ESTADO</th>
                        <th class="text-center">ACCION</th>

                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>

    </div>
</div>
<input type="hidden" name="init_at" id="init_at">
<input type="hidden" name="end_at" id="end_at">
@section('inline_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(document).ready(function(){
    function secondsToDhms(seconds) {
        seconds = Number(seconds)
        var d = Math.floor(seconds / (3600 * 24))
        var h = Math.floor((seconds % (3600 * 24)) / 3600)
        var m = Math.floor((seconds % 3600) / 60)
        var s = Math.floor(seconds % 60)
        // console.log(d, h, m, s)
    var dDisplay = d > 0 ? d + (d == 1 ? " día, " : " días, ") : ""
        var hDisplay = h > 0 ? h + (h == 1 ? " hr, " : " hrs, ") : ""
        var mDisplay = m > 0 ? m + (m == 1 ? " min, " : " mins, ") : ""
        var sDisplay = s > 0 ? s + (s == 1 ? " sg" : " sgs") : ""
        return dDisplay + hDisplay + mDisplay + sDisplay
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    $('#init_at').val(moment().startOf('month').format('YYYY-MM-DD'));
    $('#end_at').val(moment().format('YYYY-MM-DD'));
    if ($('#init_at').val() == $('#end_at').val()) {
        $('#txt_fechas').html(moment().startOf('month').format('DD/MM/YYYY'))

    } else {
        $('#txt_fechas').html(moment().startOf('month').format('DD/MM/YYYY') + ' - ' + moment().format('DD/MM/YYYY'))
    }
  $('#btnRangeDates').daterangepicker(
            {
                // locale: daterangepicker_locale,
                alwaysShowCalendars: true,
                autoApply: true,
                ranges:  {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Últimos 7 Días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 Días': [moment().subtract(29, 'days'), moment()],
                    'Mes Actual': [moment().startOf('month'), moment().endOf('month')],
                    'Anterior Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Último 3 Meses': [moment().subtract(3, 'month').startOf('month'), moment().endOf('month')],
                },
                startDate:moment().startOf('month'),
                endDate: moment(),
                maxDate: moment()
            },
            function (start, end) {

                $('#init_at').val(start.format('YYYY-MM-DD'))
                $('#end_at').val(end.format('YYYY-MM-DD'))
                if (start.format('MMMM D, YYYY') == end.format('MMMM D, YYYY')) {
                    $('#txt_fechas').html(start.format('DD/MM/YYYY'))

                } else {
                    $('#txt_fechas').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'))
                }

                dataTable.ajax.reload();
                getDataChart()

            }
    );
    var dataTable = new DataTable('#statsUser', {
        responsive: true,
        "order": [[0, "desc"]],
        "pageLength": 25,
        "searching": false,
        language: {
            url: "{{ asset('js/dataTable_langEs.json') }}",
        },
        "serverSide": true,
        "ajax": {
            "url": "{{ url(route('statistics.exams.load')) }}",
            "type": "POST",
            "data": function (d) {
                return $.extend({}, d, {
                    init_at: $('#init_at').val(),
                    end_at: $('#end_at').val(),
                    '_token': $('meta[name=csrf_token]').attr("content")

                });
            }
        },
        "columns": [
            {"data": "created_at", "orderable":false},
            {"data": "type", "orderable":false},
            {"data": "total_questions","className":"text-center", "orderable":false},
            {"data": "total_questions", "orderable":false},
            {"data": "total_correct_questions", "orderable":false},
            {"data": "total_incorrect_questions", "orderable":false},
            {"data": "score", "orderable":false},
            {"data": "score", "orderable":false}
        ],
        "aoColumnDefs": [
            {
                "aTargets": [0],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {
                    var button = moment(full.created_at).format('DD/MM/YYYY HH:mm:ss');
                    return button;
                }
            },
            {
                "aTargets": [1],
                "orderable": false,
                "mData": null,

                "mRender": function (data, type, full) {
                    switch (full.type) {
                    case 'BALANCED':
                        return 'Examen realista';
                        break;
                    case 'STANDARD':
                        return 'Examen estándar';
                        break;
                    case 'CATEGORY':
                        return 'Examen de categoría - ' + full.question_category.name;
                        break;
                    case 'SIMULACRUM':
                        return 'Examen de Simulacro';
                        break;
                    case 'SPECIAL':
                        return 'Examen Especial ';
                        break;
                    }
                }
            },
            {
                "aTargets": [3],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {
                    var button = (full.completed_at) ? moment(full.completed_at).diff(moment(full.created_at), 'seconds') : moment().diff(moment(full.created_at), 'seconds');
                    return secondsToDhms(button);
                }
            },
            {
                "aTargets": [4],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {
                    var button = (full.completed_at) ? full.total_correct_questions : ' - ';
                    return button;
                }
            },
            {
                "aTargets": [5],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {
                    var button = (full.completed_at) ? full.total_incorrect_questions : ' - ';
                    return button;
                }
            },

            {
                "aTargets": [6],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {
                    var button = (full.completed_at) ? full.score + ' % ' : ' - ';
                    return button;
                }
            },
            {
                "aTargets": [7],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {

                    var style = (full.completed_at) ?  'success' : 'warning';
                    var name = (full.completed_at) ?  'Completado' : 'En progreso';
                    return '<span class="bg-'+ style+' text-mini text-white rounded px-2">'+name+'</span>';

                }
            },
            {
                "aTargets": [8],
                "orderable": false,
                "className":'text-center',
                "mData": null,
                "mRender": function (data, type, full) {

                    if(full.completed_at){
                        url = "{{ route('statistics.index.new') }}/"+full.public_id
                        return '<a href="'+url+'" class="btn btn-primary btn-sm"><i class="bi bi-eye"></i> Detalle</a>';
                    }else{
                        if(!full.expiration_at || full.expiration_at > '{{now()}}'){
                            return '<a href="{{ route('exams.index') }}/'+full.public_id+'" class="btn btn-sm btn-success text-white"><i class="bi bi-pencil-fill"></i> Seguir</a>';
                        }
                    }



                }
            },
        ]

    });

    function createLineChart(labels,data_1,data_2,data_3,data_4,data_5){
        var ctx = document.getElementById('chart-user-exams-score-progress');

        var data1 = {
            label: "Ex. Realista",
            data: data_1,
            // data: [20, 15, 60, 60, 65, 30, 70],
            lineTension: 0,
            fill: false,
            borderColor: '#ffc107'
        };
        var data2 = {
            label: "Ex. Estándar",
            data: data_2,
            // data: [20, 15, 60, 60, 65, 30, 70],
            lineTension: 0,
            fill: false,
            borderColor: '#0f9fe2'
        };
        var data3 = {
            label: "Ex. Categoría",
            data: data_3,
            // data: [20, 15, 60, 60, 65, 30, 70],
            lineTension: 0,
            fill: false,
            borderColor: '#198754 '
        };
        var data4 = {
            label: "Ex. Simulacro",
            data: data_4,
            // data: [20, 15, 60, 60, 65, 30, 70],
            lineTension: 0,
            fill: false,
            borderColor: '#212529'
        };
        var data5 = {
            label: "Ex. Especial",
            data: data_5,
            // data: [20, 15, 60, 60, 65, 30, 70],
            lineTension: 0,
            fill: false,
            borderColor: '#dc3545'
        };
        var speedData = {
            labels:labels,
            datasets: [data1, data2, data3, data4, data5 ]
        };

        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: true,
                position: 'top',
                labels: {
                boxWidth: 80,
                fontColor: 'black'
                }
            },
            scales: {
                xAxes: [{
                type: 'time',
                distribution: 'series',
                time: {
                    displayFormats: {
                    'day': 'DD/MM/YYYY',
                    'week': 'DD/MM/YYYY',
                    'month': 'MM/YYYY',
                    'quarter': 'MM/YYYY',
                    'year': 'MM/YYYY',
                    },
                    minUnit: 'day',
                }
                }],
                yAxes: [{
                ticks: {
                    callback: function(value, index, values) {
                    return value + '%';
                    },
                    suggestedMax: 100,
                }
                }]
            }
        };
        var lineChart = new Chart(ctx, {
            type: 'line',
            data: speedData,
            options: chartOptions
        });
    }
    function getDataChart(){
        var init_at = $('#init_at').val();
        var end_at = $('#end_at').val();

        $.ajax({
            data: {init_at:init_at,end_at:end_at},
            type: "POST",
            dataType: "json",
            url: "{{ route('statistics.exams.load.chart') }}",
        })
        .done(function( data, textStatus, jqXHR ) {
            console.log();
            // createLineChart(['2023-07-31'],[50],[20],)
            var labels = [];
            var data1 = [];
            var data2 = [];
            var data3 = [];
            var data4 = [];
            var data5 = [];


            jQuery.each(data, function(index, item) {
                labels.push(index);
                data1.push(item.balanced);
                data2.push(item.standar);
                data3.push(item.category);
                data4.push(item.simulacrum);
                data5.push(item.special);
            })
            createLineChart(labels,data1,data2,data3,data4,data5);


        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
            }
        });

    }
    getDataChart()
    // $('#statsUser').DataTable({
    //         language: {
    //             url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
    //         },
    // });
})
</script>


@endsection
