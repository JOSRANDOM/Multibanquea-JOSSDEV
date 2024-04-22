<div class="card text-white mb-4" style="background: radial-gradient(circle, rgb(2, 85, 91), rgb(1, 25, 27));">
  <div class="card-body row">
    <div class="col-9">
      <h3 class="mb-3 text-warning">Obtén acceso total</h3>
      <div>Lleva tu preparación al siguiente nivel con todas las funcionalidades de {{ config('app.name') }}.</div>

      @if($showCta)
      <a class="btn btn-warning mt-3" href="{{ route('subscriptions.index') }}">Más información</a>
      @endif

    </div>
    <div class="col-3 d-flex align-items-center justify-content-center">
      <i class="fal fa-graduation-cap fa-3x opacity-3"></i>
    </div>
  </div>
</div>
