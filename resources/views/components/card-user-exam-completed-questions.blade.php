<div class="card mb-4">
  <ul class="list-group list-group-flush border-0" >

    @foreach ($exam->questions as $question)
    {{-- <pre>
      {{ dd($question->pivot) }}
    </pre> --}}
    <li class="list-group-item px-3 py-4 {{ $loop->odd ? 'bg-light' : ''}}">
      <div class="d-flex justify-content-between mb-3">
        <div class="text-muted small">
          Pregunta {{ $loop->iteration }}
        </div>

        @if ($question->pivot->answered==0)
          @if ($question->pivot->correct)
          <div class="badge bg-success fw-normal">
            <span class="me-2 fal fa-check-circle"></span>Correcta
          </div>
          @else
          <div class="badge bg-danger text-light fw-normal">
            <span class="me-2 fal fa-times-circle"></span>Incorrecta
          </div>
          @endif
        @else
        <div class="badge bg-warning text-light fw-normal">
          <span class="me-2 fal fa-times-circle"></span>Sin responder
        </div>
        @endif
      </div>
      <div class="mb-3">
        <b>{{ $question->text }}</b>
      </div>

      <ul class="fa-ul mb-3" style="list-style: none">
        @foreach ($question->answers->shuffle() as $answer)
        <li class="mb-1">
          @if ($answer->correct)
          <span class="text-success">
            <span ><i class="bi bi-check-circle-fill"></i></span>
            {{ $answer->text }}
          </span>
          @elseif ($question->pivot->answer_id === $answer->id)
          <span class="text-danger">
            <span class="fa-li"><i class="bi bi-x-circle-fill"></i></span>
            {{ $answer->text }}
          </span>
          @else
          <span class="fa-li text-muted"><i class="bi bi-circle"></i></span>

          @if (Auth::user()->isSubscribed())
          <span class="text-muted">{{ $answer->text }}</span>
          @else
          <span class="free-tier-blur text-muted">
            <x-mock-chars />
          </span>
          @endif

          @endif
        </li>
        @endforeach
      </ul>

      @if (!Auth::user()->isSubscribed())
      <a href="{{ route('subscriptions.index') }}" class="btn btn-sm btn-warning mb-3">
        Revisa todas las respuestas
      </a>
      @endif

      <div>
        <a class="text-muted small" href="#" data-bs-toggle="modal" data-bs-target="#modal-report-question-problem-{{ $question->id }}">
          <i class="fal fa-flag me-2"></i>Reportar un problema
        </a>
      </div>
      <div class="accordion accordion-flush" id="accordionFlushExample-{{ $question->id }}">
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingOne">
          <button class="accordion-button collapsed accordion-question" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne-{{ $question->id }}" aria-expanded="false" aria-controls="flush-collapseOne">
            <span class="bg-warning span-accordion"><b>Pregunta comentada - Click aqui!</b><span>
          </button>
          </h2>
          <div id="flush-collapseOne-{{ $question->id }}" class="accordion-collapse collapse accordion-questions" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample-{{ $question->id }}">
          <div class="accordion-body">
              <span style="display: inline-block"><strong>{{ $question->question_explanation }}</strong></span>
              @if ( $question->question_explanation_img != null || $question->question_explanation_img != '')
                <img style="display: block" src="{{ $question->question_explanation_img }}" width="400" height="300">
              @endif
          </div>
        </div>
      </div>

    </li>
    @endforeach

  </ul>
</div>
