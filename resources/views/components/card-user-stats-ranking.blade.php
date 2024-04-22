@php
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
@endphp
<div class="col-lg-12">
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="text-primary">Ranking {{ __('exams.types.' . $exam->type)}} ({{ $meses[\Carbon\Carbon::parse($exam->completed_at)->format('n')-1] }} {{ \Carbon\Carbon::parse($exam->completed_at)->format('Y')}})</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-sm">
                    <thead>
                        <tr>
                            <th class="text-end">#</th>
                            <th class="text-center">FECHA</th>
                            <th class="text-center">NOMBRE</th>
                            <th class="text-center">ACIERTOS</th>
                            <th class="text-center">PUNTUACIÓN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $start = 1;
                        @endphp
                        @foreach ($ranking as $ex)
                        <tr class="{{ $exam->id == $ex->id ? 'table-success' : ($exam->user_id == $ex->user_id ? 'table-secondary' : '') }}">
                            <td class="text-end">{{ $start++ }}</td>
                            <td class="text-center">{{ $ex->completed_at }}</td>
                            <td >{{ $ex->user->name }}</td>

                            <td class="text-center">{{ $ex->correct_questions()->count().'/'.$ex->questions()->count() }}</td>
                            <td class="text-center">{{ $ex->score }} %</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
