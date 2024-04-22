<div class="card mb-4 animate__animated animate__bounceIn">
  <div class="row g-0">
  <!--<iframe title="Simulacro_Cientifica - ENAE" width="600" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiNGEwNTRjZWQtN2E2Yy00YmZlLTkyYmEtYzc4YTNmODBkNDQyIiwidCI6ImQyZjQ2OGJmLTYzNTYtNDU5Mi1hNzdkLTljMTZiMTliYTk2ZiIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
  <!--<iframe title="ENAE" width="600" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiNDYwODBiZDgtMDA3MS00YjkzLTg5MDItYjUwNTA2MGI0NDkxIiwidCI6ImQyZjQ2OGJmLTYzNTYtNDU5Mi1hNzdkLTljMTZiMTliYTk2ZiIsImMiOjR9&pageName=ReportSectione6d9c3676ea5327b4a7e" frameborder="0" allowFullScreen="true"></iframe>-->
  <!--<iframe title="ENAM_RPT_F.pbixh - ENAM.PE" width="600" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiYjc3MjI4OGUtYjA5Yy00NjRiLTliN2QtNTFlMGU3MTY0YTIzIiwidCI6ImQyZjQ2OGJmLTYzNTYtNDU5Mi1hNzdkLTljMTZiMTliYTk2ZiIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
  <!--<iframe width="600" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiNDYwODBiZDgtMDA3MS00YjkzLTg5MDItYjUwNTA2MGI0NDkxIiwidCI6ImQyZjQ2OGJmLTYzNTYtNDU5Mi1hNzdkLTljMTZiMTliYTk2ZiIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>-->
    <div class="col-lg-7">
      <div class="card-body text-secondary">
        <h3 class="mb-3 text-dark">Acción recomendada</h3>

        @switch(Auth::user()->exams()->count())
        @case(0)
        <p>Empieza tu preparación con {{ config('app.name') }} iniciando tu primer examen. Te recomendamos un examen pequeño para familiarizarte con la plataforma.</p>
        <p>Un examen es un conjunto de preguntas que puedes responder para medir tus conocimientos. Pero a diferencia de un examen "real", en {{ config('app.name') }} obtendrás tus resultados al instante y la plataforma empezará a guardar y analizar tu progreso, para que así puedas optimizar tu preparación.</p>
        <a class="btn btn-primary" href="{{ route('exams.create.standard') }}">Iniciar examen pequeño</a>
        @break
        @default

        @if(Auth::user()->hasExamInProgress())
        <p>Continúa el examen que iniciaste el @formattedDate(Auth::user()->exams_in_progress[0]->created_at).</p>
        <p>Hasta el momento has respondido {{ Auth::user()->exams_in_progress[0]->getProgress() }}% de las preguntas del examen. Termínalo para ver tus resultados y obtener más información sobre tu progreso de preparación.</p>
        <a class="btn btn-primary" href="{{ route('exams.show', Auth::user()->exams_in_progress[0]) }}">Continuar examen</a>
        @else
        <p>Continúa con tu preparación iniciando un nuevo examen.</p>
        <p>Puedes revisar tu progreso e identificar áreas que quieras reforzar, o elegir el tipo de examen que más se adapte a tu tiempo.</p>
        <h3 class="mb-3 text-dark">Nuevos cambios</h3>

        <p>Un temporizador es una herramienta de cuenta regresiva que muestra el tiempo que le queda para responder el examen.</p>
        <p>Una observación o comentario por cada pregunta de cualquier examen realizado.</p>
        <a class="btn btn-primary" href="{{ route('exams.create') }}">Iniciar un examen</a>
        @endif

        @endswitch

      </div>
    </div>

    <div class="col-lg-5 p-3 d-flex justify-content-center align-items-center">      
      <img class="img-fluid" src="{{ asset('/img/illustrations/recommended-action.jpeg') }}" alt="Atención en recepción" style="max-height: 200px;" >
     <!-- <div class="col-lg-5">
      <div class="card-body text-secondary">
        <h3 class="mb-3 text-dark">Resultados Simulacro</h3>

      <a href="https://app.powerbi.com/groups/me/reports/7c1c9048-ef4d-49e3-a037-8bd8e3630052?ctid=d2f468bf-6356-4592-a77d-9c16b19ba96f&pbi_source=linkShare" target="_blank">Título del enlace</a>
    </div>-->

  </div>
</div>
