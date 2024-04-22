<div class="card mb-4">
  <div class="card-body pb-0">
    <h3 class="mb-0">Tus actividades</h3>
  </div>
  <ul class="list-group list-group-flush border-0">

    @foreach ($user->activities->sortByDesc('created_at') as $activity)
    @if (in_array($activity->activity_type_id, [1,3,4]))
    <li class="list-group-item border-0 p-3">
      <div class="d-flex mt-2 align-items-center">

        @switch($activity->activityType->name)
        @case('USER_CREATED_EXAM')
        <div class="d-flex flex-shrink-0 me-3 border border-primary rounded-circle align-items-center justify-content-center text-primary bg-light" style="height: 32px; width: 32px;">
          <span class="fal fa-book"></span>
        </div>
        <div>
          <div class="text-muted small">
            <i class="fal fa-calendar-alt me-2"></i>@formattedDate($activity->created_at)
          </div>

          @if (App\Models\Exam::find($activity->object_id))
          <div>Creaste <a href="{{ route('exams.show', App\Models\Exam::find($activity->object_id)) }}">un examen</a>.</div>
          @else
          <div>Creaste y cancelaste un examen.</div>
          @endif

        </div>
        @break
        @case('USER_CREATED_SUBSCRIPTION')
        <div class="d-flex flex-shrink-0 me-3 border border-primary rounded-circle align-items-center justify-content-center text-primary bg-light" style="height: 32px; width: 32px;">
          <span class="fal fa-glass-cheers"></span>
        </div>
        <div>
          <div class="text-muted small">
            <i class="fal fa-calendar-alt me-2"></i>@formattedDate($activity->created_at)
          </div>
          <div>Obtuviste acceso total a la plataforma.</div>
        </div>
        @break
        @case('USER_REGISTERED')
        <div class="d-flex flex-shrink-0 me-3 border border-primary rounded-circle align-items-center justify-content-center text-primary bg-light" style="height: 32px; width: 32px;">
          <span class="fal fa-handshake-alt"></span>
        </div>
        <div>
          <div class="text-muted small">
            <i class="fal fa-calendar-alt me-2"></i>@formattedDate($activity->created_at)
          </div>
          <div>¡Te uniste a {{ config('app.name') }}!</div>
        </div>
        @break
        @default
        @endswitch

      </div>
    </li>
    @endif
    @endforeach

  </ul>
</div>
