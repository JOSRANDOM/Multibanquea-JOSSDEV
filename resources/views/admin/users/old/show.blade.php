@extends('layouts.admin')
@section('head.title', 'Administración - ' . config('app.name'))

@section('content')
<x-title label="{{ $user->name }}" description="Administración de usuario" previous-url="{{ route('admin.users.index') }}" />

<main class="container-lg ml-0 px-0">
  @if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="alert-inner--text">{{ session('status') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <div class="row">
    <div class="col-12 col-lg-5 col-xl-4">
      <div class="card mb-4">
        <div class="card-body pb-0">
          <div class="mb-4 text-center">

            @if ($user->o_auth_users->first())
            <img src="{{ $user->o_auth_users->first()->avatar }}" class="img-fluid rounded-circle border border-secondary shadow" style="max-width: 100px;">
            @else
            <span class="fal fa-user img-fluid rounded-circle border border-secondary shadow" style="height: 100px; width: 100px;"></span>
            @endif

          </div>
          <h3 class="mb-3 text-center">{{ $user->name }}</h3>
          <div class="mb-3">
            <span class="text-muted"><i class="fal fa-calendar-alt me-2"></i>Registrado el @formattedDate($user->created_at)</span>
          </div>
          <div class="mb-3">
            <span class="text-muted">ID:</span> {{ $user->id }}
          </div>
          <div class="mb-3">
            <span class="text-muted">Correo electrónico:</span> {{ $user->email }}
          </div>
            @if ($user->study_id!='')
                <div class="mb-3">
                    <span class="text-muted">ID de Estudiante:</span> {{ $user->study_id }}
                </div>
                <div class="mb-3">
                    <span class="text-muted">Centro de Estudios:</span> {{ $user->study_center }}
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-update-password">
                        Cambiar Contraseña
                    </button>
                </div>
                <x-admin.modals.update-password :user="$user" />
            @endif
            <div class="mb-3">
            <span class="text-muted">Cuentas de redes vinculadas:</span>

            @foreach ($user->o_auth_users as $o_auth_user)
            <div class="badge bg-secondary fw-normal">{{ $o_auth_user->provider }}</div>
            @endforeach

          </div>
          @if ($user->isSubscribed())
          <div class="mb-3 badge bg-warning fw-normal">Suscripción activa</div>
          @endif
          @if ($user->study_id!='')
            <div class="badge bg-success fw-normal" style="height: 20px!important;">Cuenta de Estudiante</div>
          @endif


        </div>
      </div>
      <div class="card mb-4">
        <div class="card-body pb-0">
          <div class="mb-3">
            <span class="text-muted">Suscripciones activadas:</span> {{ $user->subscriptions()->count() }}
          </div>
          <div class="mb-3">
            <span class="text-muted">Referencias de compra generadas:</span> {{ $user->checkout_references()->count() }}
          </div>
          <div class="mb-3">
            <span class="text-muted">Exámenes iniciados:</span> {{ $user->exams()->count() }}
          </div>
          <div class="mb-3">
            <span class="text-muted">Actividades realizadas:</span> {{ $user->activities()->count() }}
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-lg-7 col-xl-8">
      <div class="card mb-4">
        <div class="card-body border-bottom pb-0">
          <h3 class="mb-3">Suscripciones</h3>
        </div>
        <ul class="list-group list-group-flush border-0">

          @foreach ($user->subscriptions->sortByDesc('created_at') as $subscription)
          <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
            <div class="d-flex justify-content-between mb-1">
              <div class="text-muted small">
                <i class="fal fa-calendar-alt me-2"></i>Creada el @formattedDateTime($subscription->created_at)
              </div>

              @if ($subscription->isActive())
              <div class="badge bg-warning fw-normal">Activa</div>
              @else
              <div class="badge bg-secondary fw-normal">Inactiva</div>
              @endif

            </div>
            <div class="mb-1"><b>Plan: {{ $subscription->plan->name }}</b> <span class="text-muted">- {{ $subscription->plan->slug }}</span></div>
            <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $subscription->id }}</div>
            <div class="mb-1 small"><span class="text-muted">Inicio:</span> @formattedDateTime($subscription->starts_at)</div>
            <div class="small"><span class="text-muted">Fin:</span> @formattedDateTime($subscription->ends_at)</div>
          </li>
          @endforeach

          @can('edit subscriptions')
          <li class="list-group-item p-3">
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-subscription">
              Agregar suscripción
            </button>
            <x-admin.modals.add-subscription :user="$user" />
          </li>
          @endcan

        </ul>
      </div>

      <div class="card mb-4">
        <div class="card-body border-bottom pb-0">
          <h3 class="mb-3">Referencias de compra</h3>
        </div>
        <ul class="list-group list-group-flush border-0">

          @foreach ($user->checkout_references->sortByDesc('created_at') as $checkout_reference)
          <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
            <div class="mb-1 text-muted small">
              <i class="fal fa-calendar-alt me-2"></i>Generada el @formattedDateTime($checkout_reference->created_at)
            </div>
            <div class="mb-1"><b>Plan: {{ $checkout_reference->plan->name }}</b></div>
            <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $checkout_reference->id }}</div>
            <div class="mb-1 small"><span class="text-muted">Precio total:</span> S/ @formattedPrice($checkout_reference->total_price)</div>
            <div class="mb-1 small">
              <span class="text-muted">Estado de pago:</span>

              @if ($checkout_reference->isPaid())
              <div class="badge bg-success fw-normal">Pago completo</div>
              @else
              <div class="badge bg-secondary fw-normal">Pago pendiente</div>
              @endif

            </div>
            <div class="small"><span class="text-muted">Monto pendiente:</span> S/ @formattedPrice(($checkout_reference->total_price - $checkout_reference->amount_paid))</div>
          </li>
          @endforeach

        </ul>
      </div>

      <div class="card mb-4">
        <div class="card-body border-bottom pb-0">
          <h3 class="mb-3">Exámenes</h3>
        </div>
        <ul class="list-group list-group-flush border-0">

          @foreach ($user->exams->sortByDesc('created_at') as $exam)
          <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
            <div class="mb-1 text-muted small">
              <i class="fal fa-calendar-alt me-2"></i>Iniciado el @formattedDateTime($exam->created_at)
            </div>
            <div class="mb-1">
              <b>
                {{ __('exams.types.' . $exam->type) }}

                @if ($exam->type === 'CATEGORY')
                ({{ $exam->question_category->name }})
                @endif

              </b>
              de {{ $exam->questions()->count() }} preguntas
            </div>
            <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $exam->id }}</div>
            <div class="mb-1 small"><span class="text-muted">ID público:</span> {{ $exam->public_id }}</div>

            @if(!$exam->isCompleted())
            <div class="small"><span class="text-muted">Estado:</span> En progreso ({{ $exam->getProgress() }}% respondido)</div>
            @else
            <div class="small"><span class="text-muted">Estado:</span> Completado el @formattedDateTime($exam->completed_at) (Puntuación de {{ $exam->score }}%)</div>
            @endif

          </li>
          @endforeach

        </ul>
      </div>

      <div class="card mb-4">
        <div class="card-body border-bottom pb-0">
          <h3 class="mb-3">Actividades</h3>
        </div>
        <ul class="list-group list-group-flush border-0">
          @foreach ($user->activities->sortByDesc('created_at') as $activity)
          <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
            <div class="mb-1 text-muted small">
              <i class="fal fa-calendar-alt me-2"></i>Realizada el @formattedDateTime($activity->created_at)
            </div>
            <div class="mb-1"><b>{{ $activity->activityType->name }}</b></div>
            <div class="small"><span class="text-muted">ID:</span> {{ $activity->id }}</div>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</main>
@endsection
