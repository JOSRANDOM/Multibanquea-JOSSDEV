<div class="card mb-4">
  <div class="card-body border-bottom">
    <h3 class="mb-0">Rendimiento por categoría</h3>
  </div>
  <ul class="list-group list-group-flush border-0">
    @if ($user->exams_completed->count() == 0)
    <li class="list-group-item p-3 text-muted">
      Completa al menos 1 examen para ver los detalles de tu rendimiento.
    </li>
    @else
    @foreach ($question_categories_scores as $question_category_score)
    <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
      <div class="d-flex mt-2 align-items-center">
        <div class="d-flex flex-shrink-0 me-3 align-items-center justify-content-center" style="height: 32px; width: 32px;">

          @if ($question_category_score->questions < 2)
          <span class="fal fa-2x fa-question-circle text-muted"></span>
          @elseif ($question_category_score->score > 70)
          <span class="fal fa-2x fa-smile-beam text-success"></span>
          @elseif ($question_category_score->score > 40)
          <span class="fal fa-2x fa-meh-rolling-eyes text-warning"></span>
          @else
          <span class="fal fa-2x fa-tired text-danger"></span>
          @endif

        </div>
        <div>
          <div class="mb-2"><b>{{ $question_category_score->question_category_name }}</b> <span class="text-muted"> - {{ trans_choice('questions.count', $question_category_score->questions) }}</div>
          <div>Correctas: {{ $question_category_score->correct_questions }}</div>
          <div>Incorrectas: {{ $question_category_score->incorrect_questions }}</div>
          <div>Puntuación: <b>{{ $question_category_score->score }}%</b></div>
          <div class="mt-2"><a class="btn btn-primary btn-sm" href="{{ route('statistics.showQuestionCategory', $question_category_score->question_category_id) }}">Más detalles</a></div>
        </div>
      </div>
    </li>
    @endforeach
    @endif

  </ul>
</div>
