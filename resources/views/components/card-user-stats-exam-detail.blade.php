<div class="col-lg-12">

    <div class="card mb-4">
        <div class="card-header">
            <h3 class="text-primary">Información</h3>
        </div>
        <div class="card-body">
            <div class="row ">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12 mb-4 text-center">
                            <h2 class="fs-1 text-primary ">{{ $exam->questions()->count() }}</h2>
                            <p>Total de Preguntas</p>
                        </div>
                        <div class="col-lg-12 mb-4 text-center">
                            <h2 class="fs-1 text-primary">{{ $exam->correct_questions()->count() }}</h2>
                            <p>Preguntas acertadas</p>
                        </div>
                        <div class="col-lg-12 mb-4  text-center">
                            <h2 class="fs-1 text-primary">{{ $exam->incorrect_questions()->count() }}</h2>
                            <p>Preguntas fallidas</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <select name="slcType" id="slcType"  class="form-select " {{ ($exam->type=='CATEGORY' ) ? 'DISABLED' : '' }} style="display:none">
                        <option value="0">POR CATEGORÍAS</option>
                        @foreach ($categories as $key => $name)
                            <option value="{{ $key }}" {{ ($exam->type=='CATEGORY' &&  $exam->question_category_id == $key ) ? 'SELECTED' : '' }} >{{ $name }}</option>
                        @endforeach
                    </select>
                    <div class="chart-lg">
                        <canvas id="chart-detail-exam" ></canvas>
                    </div>
                </div>
                @php
                $time_seconds_total = \Carbon\Carbon::parse($exam->created_at)->diffInSeconds(\Carbon\Carbon::parse($exam->completed_at));
                $time_seconds_prom = round(\Carbon\Carbon::parse($exam->created_at)->diffInSeconds(\Carbon\Carbon::parse($exam->completed_at))/$exam->questions()->count()) ;
                @endphp
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12 mb-4 text-center">
                            <h2 class="fs-1 text-primary ">{{ sprintf('%02d:%02d:%02d', ($time_seconds_total/ 3600),($time_seconds_total/ 60 % 60), $time_seconds_total% 60) }}</h2>
                            <p>Tiempo examen</p>
                        </div>
                        <div class="col-lg-12 mb-4 text-center">
                            <h2 class="fs-1 text-primary">{{ sprintf('%02d:%02d:%02d', ($time_seconds_prom/ 3600),($time_seconds_prom/ 60 % 60), $time_seconds_prom% 60) }}</h2>
                            <p>Tiempo promedio preg.</p>
                        </div>
                        <div class="col-lg-12 mb-4 text-center">
                            <h2 class="fs-1 text-primary">{{ $exam->score }} %</h2>
                            <p>Puntuación.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="text-primary">Detalle Categorias - Subcaterias</h3>
        </div>
        <div class="card-body">
            @foreach ($data_questions as $category)

                @php
                $score = round($category['correct_question'] /  $category['total'] * 100);
                $className = ($score < 55) ? 'bg-danger' : ($score < 80 ? 'bg-warning' : 'bg-success')
                @endphp
                <h4 class="font-weight-bold">{{ $category['name'] }} ( {{ $category['correct_question'] }} de {{ $category['total'] }} )<span class="float-end">{{ $score }}%</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar {{ $className }}" role="progressbar" style="width: {{ $score }}%" aria-valuenow="{{ $score }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="row pt-2">
                    @foreach ($category['subcategories'] as $subcategory)
                        <div class="col-lg-4">
                            @php
                            $className2 = ($subcategory['score'] < 55) ? 'bg-danger' : ($subcategory['score'] < 80 ? 'bg-warning' : 'bg-success')
                            @endphp
                            <h4 class="small font-weight-bold">{{ $subcategory['name'] }} ( {{ $subcategory['correct_question'] }} de {{ $subcategory['total'] }} )<span class="float-end">{{ $subcategory['score'] }}%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar {{ $className2 }}" role="progressbar" style="width: {{ $subcategory['score'] }}%" aria-valuenow="{{ $subcategory['score'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <hr>
            @endforeach
        </div>
    </div>
</div>
  @section('inline_scripts')

  <script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $('#slcType').change(function(){
        getData()
    })
    var lineChart;
    function drawRadar(labels,datasets){

        // let chartStatus = Chart.getChart(lineChart); // <canvas> id
        var ctx = document.getElementById('chart-detail-exam');
        if (lineChart != undefined) {
            lineChart.clear();

        }




        var speedData = {
            labels:labels,
            datasets: datasets
        };
        var chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            elements: {
            line: {
                borderWidth: 3
            },
            scales: {
                r: {
                    angleLines: {
                        display: false
                    },
                    suggestedMin: 0,
                    suggestedMax: 100
                }
            }
        }

        };
        lineChart = new Chart(ctx, {
            type: 'radar',
            data: speedData,
            options: chartOptions
        });

    }
    function getData(){
        var slcType =  $('#slcType').val();
        $.ajax({
            data: {exam:'{{ $exam->public_id }}',type:slcType},
            type: "POST",
            dataType: "json",
            url: "{{ route('statistics.exams.detail.load') }}",
        })
        .done(function( data, textStatus, jqXHR ) {
            console.log(data.labels);
            console.log(data.datasets);
            drawRadar(data.labels,data.datasets);


        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
            }
        });
    }

    getData()


})
    // function drawStats(){
    //     if (typeof Chart !== "undefined") {
    //         const ctx = document.getElementById('chart-detail-exam');
    //         const data = {
    //             labels: [
    //                 'Correctas',
    //                 'Incorrectas',

    //             ],
    //             datasets: [{
    //                 label: 'My First Dataset',
    //                 data: [{{ $exam->correct_questions()->count() }}, {{ $exam->incorrect_questions()->count() }}],
    //                 backgroundColor: [
    //                     '#198754',
    //                     '#dc3545',
    //                 ],
    //                 hoverOffset: 2
    //             }]
    //             };
    //         const config = {
    //             type: 'doughnut',
    //             data: data,
    //         };

    //         new Chart(ctx, config);
    //     }else{
    //         setTimeout(drawStats, 250);
    //     }

    // }
    // drawStats()

  </script>
@endsection
