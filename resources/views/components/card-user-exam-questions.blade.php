<div class="card mb-4" ondragstart="return false" onselectstart="return false">
  <ul class="list-group list-group-flush border-0">

    @foreach ($exam->questions as $question)
    <li class="list-group-item px-3 py-4 {{ $loop->odd ? 'bg-light' : ''}}">
      <div class="d-flex justify-content-between mb-3">
        <div class="text-muted small">
          Pregunta {{ $loop->iteration }}
        </div>
        @if ($question->pivot->answered==0)
            @if ($question->pivot->answer_id)
            <div class="badge bg-success fw-normal">
            <span class="me-2 fal fa-check-square"></span>Respondida
            </div>
            @else
            <div class="badge bg-warning text-dark fw-normal">
                <span class="me-2 fal fa-square"></span>Sin responder
            </div>
            @endif
        @else
            <div class="badge bg-warning text-dark fw-normal">
                <span class="me-2 fal fa-square"></span>Sin responder
            </div>
        @endif

      </div>
      <div class="mb-3">
        {{ $question->text }}
      </div>

      @if ($question->pivot->answer_id)
      <div class="mb-3">
         @if( App\Models\ExamQuestion::find($exam->questions->find($question)->pivot->id)->answered == 0)
              <span class="text-muted"><b>Tu respuesta:</b></span> {{ App\Models\Answer::find($question->pivot->answer_id)->text }}
         @endif
         @if( App\Models\ExamQuestion::find($exam->questions->find($question)->pivot->id)->answered == 1)
              <span class="text-muted"><b>Tu respuesta:</b></span> No respondido
         @endif


      </div>
      @endif




      <div>
        @if (is_null($question->pivot->answer_id))
        <a href="{{ route('exams.show.question', [$exam, $question]) }}" class="btn btn-sm btn-primary">Responder</a>
        @endif

        @if(!is_null($question->pivot->answer_id) && !isTimeExpired($exam->expiration_at))
            <a href="{{ route('exams.show.question', [$exam, $question]) }}" class="btn btn-sm btn-secondary">Cambiar respuesta</a>
        @endif
      </div>


    </li>
    @endforeach

  </ul>
</div>
