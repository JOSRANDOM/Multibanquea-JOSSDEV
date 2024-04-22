<div class="card mb-4">
  <div class="card-body">
    <h3 class="mb-3">Detalles del examen</h3>
    <div class="mb-3">
      <b>
        {{-- {{ __('exams.types.' . $exam->type) }} --}}
        @if($exam->type == 'EXTRAORDINARY')
        @elseif($exam->type == 'SIMULACRUM' && $exam->simulacrum)
            {{ $exam->simulacrum_data->name }}
        @else
            {{ __('exams.types.' . $exam->type) }}
        @endif
        @if ($exam->type === 'CATEGORY')
        ({{ $exam->question_category->name }})
        @endif
      </b>
      de {{ $exam->questions()->count() }} preguntas, iniciado el @formattedDate($exam->created_at) y completado el @formattedDate($exam->completed_at).
    </div>
    <div class="mb-2">Puntuación: <b>{{ $exam->score }}%</b></div>
    @if ($exam->type === 'SIMULACRUM')
        @if($exam->simulacrum)
            <div class="mb-2 ">Nota: <b>{{ round( ( intval($exam->simulacrum_data->punctuation) / intval($exam->simulacrum_data->questions )) * $exam->total_correct_questions) }}</b></div>
        @endif
    {{-- <div class="mb-2">Nota: <b>{{ $exam->correct_questions()->count() * 0.2 }}</b></div> --}}
    @endif
    <div class="progress progress-lg rounded mb-3">
      <div class="progress-bar bg-success rounded" role="progressbar" aria-valuenow="{{ $exam->score }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $exam->score }}%;"></div>
    </div>
    <div class="mb-1"><span class="fal fa-fw fa-check-circle text-success me-1"></span>Preguntas correctas: <b>{{ $exam->correct_questions()->count() }}</b></div>
    <div><span class="fal fa-fw fa-times-circle text-danger me-1"></span>Preguntas incorrectas: <b>{{ $exam->incorrect_questions()->count() }}</b></div>
  </div>
</div>
