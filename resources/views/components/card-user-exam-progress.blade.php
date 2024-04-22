<div class="card bg-dark text-white mb-4">
  <div class="card-body">
    <h3 class="h5 mb-3 opacity-4">Detalles del examen</h3>
    <div class="mb-3 opacity-3">
      <b>        
        @if($exam->type=='EXTRAORDINARY')
          {{ $exam->extraordinary_data->name }}
        @elseif($exam->type ='SIMULACRUM' && $exam->simulacrum)
            {{ $exam->simulacrum_data->name }}
        @else
            {{ __('exams.types.' . $exam->type) }}
            @if ($exam->type === 'CATEGORY')
            ({{ $exam->question_category->name }})
            @endif
        @endif
      </b>
      de {{ $exam->questions()->count() }} preguntas, iniciado el @formattedDate($exam->created_at).
    </div>
    <div class="mb-2 opacity-3">Has respondido {{ $exam->getProgress() }}% ({{ $exam->getProgressNumber() }}) de las preguntas del examen.</div>
    <div class="progress progress-lg rounded mb-0">
      <div class="progress-bar bg-primary rounded" role="progressbar" aria-valuenow="{{ $exam->getProgress() }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $exam->getProgress() }}%;"></div>
    </div>
  </div>
</div>
