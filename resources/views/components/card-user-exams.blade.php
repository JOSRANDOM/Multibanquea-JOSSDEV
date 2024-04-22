<div class="card mb-4">
  <ul class="list-group list-group-flush border-0">

    @if ($user->exams()->count() == 0)
    <li class="list-group-item p-3 text-muted">
      Aún no has iniciado ningún examen.
    </li>
    @else
    @foreach ($user->exams->sortByDesc('created_at') as $exam)
    <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
      <div class="d-flex mt-2 align-items-center">
        <div class="d-flex flex-shrink-0 me-3 border {{ !$exam->isCompleted() ? 'border-success text-success' : 'border-primary text-primary'}} rounded-circle align-items-center justify-content-center {{ $loop->even ? 'bg-light' : 'bg-white'}}" style="height: 32px; width: 32px;">
          <span class="fal {{ !$exam->isCompleted() ? 'fa-book-open animate__animated animate__flash animate__infinite animate__slower' : 'fa-book'}}"></span>
        </div>
        <div>

          @if (!Auth::user()->isSubscribed() && $loop->iteration > 3)
          <a href="{{ route('subscriptions.index') }}" class="btn btn-warning shadow" style="position: absolute; top: 50%; transform: translateY(-50%); z-index:1;">
            Revisa exámenes anteriores
          </a>
          <div class="text-muted small mb-1 free-tier-blur">
            <i class="fal fa-calendar-alt me-2"></i>Iniciado el
            <x-mock-chars charsMax="10" charsMin="10" wordsMax="1" wordsMin="1" />
          </div>
          <div class="mb-1 free-tier-blur">
            <b>
              <x-mock-chars charsMax="10" charsMin="6" wordsMax="2" wordsMin="2" />
            </b> de
            <x-mock-chars charsMax="3" charsMin="1" wordsMax="1" wordsMin="1" /> preguntas
          </div>
          <div class="mb-1 free-tier-blur">Completado el
            <x-mock-chars charsMax="10" charsMin="10" wordsMax="1" wordsMin="1" />
          </div>
          <div class="free-tier-blur">Puntuación: <b>
              <x-mock-chars charsMax="4" charsMin="2" wordsMax="1" wordsMin="1" />
            </b>
          </div>
          @else
          <div class="text-muted small mb-3">
            <i class="fal fa-calendar-alt me-2"></i>Iniciado el @formattedDate($exam->created_at)
          </div>
          <div class="mb-1">
            <b>
                @if($exam->type == 'EXTRAORDINARY')
                  {{ $exam->extraordinary_data->name }}
                @elseif($exam->type == 'SIMULACRUM' && $exam->simulacrum)
                    {{ $exam->simulacrum_data->name }}
                @else
                    {{ __('exams.types.' . $exam->type) }}
                @endif
              @if ($exam->type === 'CATEGORY')
              ({{ $exam->question_category->name }})
              @endif
            </b>
            de {{ $exam->questions()->count() }} preguntas
          </div>

          @if(!$exam->isCompleted())
          <div class="mb-3 opacity-3">Has respondido {{ $exam->getProgress() }}% de las preguntas del examen.</div>
          <a href="{{ route('exams.show', $exam) }}" class="btn btn-sm btn-primary">Continuar examen</a>
          <a class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
            data-bs-target="#modal-cancel-exam-{{ $exam->id }}" href="#modal-cancel-exam-{{ $exam->id }}" role="button">
            Cancelar examen
          </a>
          <x-modal-cancel-exam :exam="$exam" />
          @else
          <div class="mb-1 opacity-3">Completado el @formattedDate($exam->completed_at)</div>
          <div class="mb-1 opacity-3">Puntuación: <b>{{ $exam->score }}%</b></div>
          @if($exam->type =='SIMULACRUM' && $exam->simulacrum)
          <div class="mb-3 opacity-3">Nota: <b>{{ round( ( intval($exam->simulacrum_data->punctuation) / intval($exam->simulacrum_data->questions )) * $exam->total_correct_questions) }}</b></div>
          @endif
          @if($exam->type =='EXTRAORDINARY')
          <div class="mb-3 opacity-3">Nota: <b>{{ round( ( intval($exam->extraordinary_data->punctuation) / intval($exam->extraordinary_data->questions )) * $exam->total_correct_questions) }}</b></div>
          @endif
          <a href="{{ route('exams.show', $exam) }}" class="btn btn-sm btn-outline-primary">Revisar examen</a>
          @endif

          @endif

        </div>
      </div>
    </li>
    @endforeach
    @endif

  </ul>
</div>
