<div class="card mb-4">
  <div class="card-body pb-0">
    <h3 class="mb-0">Tu historial de suscripción</h3>
  </div>
  <ul class="list-group list-group-flush border-0">

    @forelse ($user->subscriptions->sortByDesc('starts_at') as $subscription)
    <li class="list-group-item border-0 p-3">
      <div class="d-flex mt-2 align-items-center">
        <div class="d-flex flex-shrink-0 me-3 border border-primary rounded-circle align-items-center justify-content-center text-primary bg-light" style="height: 32px; width: 32px;">
          <span class="fal fa-glass-cheers"></span>
        </div>
        <div>
          <div class="text-muted small">
            <i class="fal fa-calendar-alt me-2"></i>@formattedDate($subscription->starts_at)
          </div>
          <div>Obtuviste acceso total a la plataforma hasta el @formattedDate($subscription->ends_at).</div>
        </div>
      </div>
    </li>
    @empty
    <li class="list-group-item border-0 p-3 text-muted">
      Aún no has obtenido acceso total a la plataforma. ¿Qué esperas para llevar tu preparación al siguiente nivel?
    </li>
    @endforelse

  </ul>
</div>
