<div class="card mb-4">
  <div class="row g-0">

    <div class="col-lg-7">
      <div class="card-body">
        <h3 class="mb-3">Resumen</h3>

        @switch($exams_completed_count)
        @case(0)
        <p>Aún no has completado ningún examen.</p>
        @break
        @default
        <p>Has completado {{ trans_choice('exams.count', $exams_completed_count) }}. El más reciente fue el @formattedDate($latest_exam_completed->completed_at) y respondiste {{ $latest_exam_completed->score }}% de las preguntas correctamente.</p>
        <p>Hasta el momento has respondido {{ $questions_answered }} preguntas en total. De éstas, has respondido {{ $questions_answered_correctly }} correctamente.</p>
        @endswitch

      </div>
    </div>

    <div class="col-lg-5 p-3 d-flex justify-content-center align-items-center">
      <img class="img-fluid" src="{{ asset('/img/illustrations/recommended-action.jpeg') }}" alt="Atención en recepción" style="max-height: 200px;">
    </div>

  </div>
</div>
