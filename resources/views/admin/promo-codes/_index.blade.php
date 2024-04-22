@extends('layouts.admin')
@section('head.title', 'Administración - ' . config('app.name'))

@section('content')
<x-title label="Códigos promocionales" description="Administración de códigos promocionales"
  previous-url="{{ route('admin.index') }}" />

<main class="container-lg ml-0 px-0">
  @if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="alert-inner--text">{{ session('status') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif


  <button type="button" class="btn btn-lg btn-outline-light mb-4" style="margin-right: 80px" data-bs-toggle="modal" data-bs-target="#modal-new">
    <span class="fal fa-fw fa-plus me-2"></span>Crear un código promocional
  </button>

  <form action="{{ route('admin.promo-codes.index') }}" method="GET" role="search" class="form-inline">
      <input type="text" class="search-promo-code mb-4 float-right" placeholder="Buscar código" name="term" id="term" value="{{ $term ?? '' }}">
      <button class="btn btn-info btn-lg mb-4 btn-search-code" type="submit" title="Buscar">
            <span class="fas fa-search"></span>
      </button>
  </form>


  <div class="card mb-4">
    <div class="card-body border-bottom pb-0">
      <h3 class="mb-3">Activos</h3>
    </div>
    <ul class="list-group list-group-flush border-0">

      @foreach ($active_plans as $plan)
      <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
        <div class="d-flex justify-content-between mb-1">
          <div class="text-muted small">
            <i class="fal fa-calendar-alt me-2"></i>Creado el @formattedDate($plan->created_at)
          </div>
          <div class="badge bg-success fw-normal">Código activo</div>
        </div>
        <div class="mb-1"><b>{{ $plan->promo_code }}</b></div>
        <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $plan->id }}</div>
        <div class="mb-1 small"><span class="text-muted">Enlace:</span> <a
            href="{{ route('promo.show', $plan->promo_code) }}" target="_blank">{{ route('promo.show', $plan->promo_code) }}</a>
        </div>
        <div class="mb-1 small"><span class="text-muted">Nombre del plan:</span> {{ $plan->name }}</div>
        <div class="mb-1 small"><span class="text-muted">Enlace de pago:</span> <a
            href="{{ route('subscriptions.checkout', $plan) }}"
            target="_blank">{{ route('subscriptions.checkout', $plan) }}</a></div>
        <div class="mb-1 small"><span class="text-muted">Meses:</span> {{ $plan->months }}</div>
        <div class="mb-1 small"><span class="text-muted">Costo mensual:</span> S/ @formattedPrice($plan->monthly_price)
        </div>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
          data-bs-target="#modal-deactivate-{{ $plan->id }}">Desactivar</a>
      </li>

      {{-- Deactivate plan modal -----------------------------------------------------}}
      <div class="modal fade" id="modal-deactivate-{{ $plan->id }}" tabindex="-1"
        aria-labelledby="modal-deactivate-{{ $plan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="POST" action="{{ route('admin.promo-codes.update') }}">
              @csrf
              @method('PUT')
              <div class="modal-header border-0">
                <h5 class="modal-title" id="modal-deactivate-{{ $plan->id }}-label">Desactivar código promocional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <div><b>{{ $plan->promo_code }}</b></div>
                  <div class="small"><span class="text-muted">ID:</span> {{ $plan->id }}</div>
                  <input name="plan" value="{{ $plan->id }}" hidden>
                  <input name="active" value="0" hidden>
                </div>
                <hr>
                <div>¿Estás seguro que deseas desactivar este código promocional?</div>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Desactivar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

    </ul>
  </div>

  <div class="card mb-4">
    <div class="card-body border-bottom pb-0">
      <h3 class="mb-3">Inactivos</h3>
    </div>
    <ul class="list-group list-group-flush border-0">

      @foreach ($inactive_plans as $plan)
      <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
        <div class="d-flex justify-content-between mb-1">
          <div class="text-muted small">
            <i class="fal fa-calendar-alt me-2"></i>Creado el @formattedDate($plan->created_at)
          </div>
          <div class="badge bg-danger fw-normal">Código inactivo</div>
        </div>
        <div class="mb-1"><b>{{ $plan->promo_code }}</b></div>
        <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $plan->id }}</div>
        <div class="mb-1 small"><span class="text-muted">Enlace:</span> <a
            href="{{ route('promo.show', $plan->promo_code) }}" target="_blank">{{ route('promo.show', $plan->promo_code) }}</a>
        </div>
        <div class="mb-1 small"><span class="text-muted">Nombre del plan:</span> {{ $plan->name }}</div>
        <div class="mb-1 small"><span class="text-muted">Enlace de pago:</span> <a
            href="{{ route('subscriptions.checkout', $plan) }}"
            target="_blank">{{ route('subscriptions.checkout', $plan) }}</a></div>
        <div class="mb-1 small"><span class="text-muted">Meses:</span> {{ $plan->months }}</div>
        <div class="mb-1 small"><span class="text-muted">Costo mensual:</span> S/ @formattedPrice($plan->monthly_price)
        </div>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
          data-bs-target="#modal-deactivate-{{ $plan->id }}">Activar</a>
      </li>

      {{-- Activate plan modal -----------------------------------------------------}}
      <div class="modal fade" id="modal-deactivate-{{ $plan->id }}" tabindex="-1"
        aria-labelledby="modal-deactivate-{{ $plan->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="POST" action="{{ route('admin.promo-codes.update') }}">
              @csrf
              @method('PUT')
              <div class="modal-header border-0">
                <h5 class="modal-title" id="modal-deactivate-{{ $plan->id }}-label">Activar código promocional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <div><b>{{ $plan->promo_code }}</b></div>
                  <div class="small"><span class="text-muted">ID:</span> {{ $plan->id }}</div>
                  <input name="plan" value="{{ $plan->id }}" hidden>
                  <input name="active" value="1" hidden>
                </div>
                <hr>
                <div>¿Estás seguro que deseas activar este código promocional?</div>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Activar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

    </ul>
  </div>
</main>

{{-- New plan with promo code modal -----------------------------------------------------}}
<div class="modal fade" id="modal-new" tabindex="-1" aria-labelledby="modal-new" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.promo-codes.store') }}">
        @csrf
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-new-label">Crear un código promocional</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="input-promo-code" class="form-label">Código</label>
            <input type="text" class="form-control" id="input-promo-code" name="promo_code" required>
            <div id="emailHelp" class="form-text">Sin espacios. Sólo números, letras y guiones.</div>
          </div>
          <div class="mb-3">
            <label for="input-plan-name" class="form-label">Nombre del plan</label>
            <input type="text" class="form-control" id="input-plan-name" name="plan_name" required>
            <div id="emailHelp" class="form-text">Ejemplos: "Acceso mensual", "Acceso bimestral", "Acceso anual"</div>
          </div>
          <div class="mb-3">
            <label for="input-months" class="form-label">Meses</label>
            <input type="number" class="form-control" id="input-months" name="months" required>
          </div>
          <div class="mb-3">
            <label for="input-monthly-price" class="form-label">Precio mensual</label>
            <div class="input-group mb-3">
              <span class="input-group-text">S/</span>
              <input type="number" class="form-control" id="input-monthly-price" name="monthly_price" required>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
