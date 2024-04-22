@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">{{ $user->name }}</h1>
    <a class="btn btn-danger btn-sm float-end" href="{{ route('admin.users.index') }}" title="Volver"><i class="bi bi-arrow-return-left"></i> Volver</a>
</div>
@if (session('status'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('status') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ $message }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header bg-primary">
            <h4 class="text-white">Perfil</h4>
        </div>
        <div class="card-body py-4">
            <div class="row g-0 mb-2">
                <div class="col-lg-3 text-center">
                    @if ($user->o_auth_users->first())
                        <img src="{{ $user->o_auth_users->first()->avatar }}" class="img-fluid rounded-circle border border-secondary shadow" style="max-width: 100px;">
                    @else
                        <i class="fas fa-laugh-wink w-100" style="font-size: 6em;max-width: 100px;"></i>
                        {{-- <span class="fal fa-user img-fluid rounded-circle border border-secondary shadow" style="height: 100px; width: 100px;"></span> --}}
                    @endif
                    <h3 class="mt-3 mb-3 text-center">{{ $user->name }}</h3>
                    @if ($user->isSubscribed())
                    <div class="mb-3 badge bg-warning fw-normal">Suscripción activa</div>
                    @endif
                    @if ($user->study_id!='')
                        <div class="badge bg-success fw-normal" style="height: 20px!important;">Cuenta de Estudiante</div>
                    @endif
                    @if ($user->study_id !='')
                        <div class="mb-3">
                            <span class="text-muted">ID de Estudiante:</span> {{ $user->study_id }}<br>
                            <span class="text-muted">Centro de Estudios:</span> {{ $user->study_center }}
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-primary w-75" data-bs-toggle="modal" data-bs-target="#modal-update-password">
                                <i class="bi bi-key"></i> Contraseña
                            </button>
                        </div>
                        <x-admin.modals.update-password :user="$user" />
                    @endif
                    @can('edit subscriptions')
                    <div>
                        <button type="button" class="btn btn-sm btn-success w-75" data-bs-toggle="modal" data-bs-target="#modal-add-subscription">
                            <i class="bi bi-credit-card"></i> Agregar suscripción
                        </button>
                        <x-admin.modals.add-subscription :user="$user" />
                    </div>

                    @endcan
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text" value="{{ $user->id }}" readonly>
                                <label for="floatingTextarea"> Codigo</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="@formattedDate($user->created_at)" readonly>
                                <label for="floatingTextarea"><i class="bi bi-calendar"></i> Registrado</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="{{ $user->email }}" readonly>
                                <label for="floatingTextarea"><i class="bi bi-envelope"></i> Correo</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="{{ $user->phone }}" readonly>
                                <label for="floatingTextarea"><i class="bi bi-phone"></i> Telefono</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="{{ $user->subscriptions()->count() }}" readonly>
                                <label for="floatingTextarea">Suscripciones activadas</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="{{ $user->checkout_references()->count() }}" readonly>
                                <label for="floatingTextarea">Referencias de compra generadas</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="{{ $user->exams()->count() }}" readonly>
                                <label for="floatingTextarea">Exámenes iniciados</label>
                            </div>
                        </div>
                        <div class="col-lg-3 mb-2">
                            <div class="form-floating">
                                <input class="form-control text-center" type="text " value="{{ $user->activities()->count() }}" readonly>
                                <label for="floatingTextarea">Actividades realizadas</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <h5 class="mt-4">Cuentas de redes vinculadas:</h5>
                            @foreach ($user->o_auth_users as $o_auth_user)
                            <div class="badge bg-secondary fw-normal">{{ $o_auth_user->provider }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div class="card mb-4">
        <a href="#collapseCardExample" class="d-block card-header py-3 bg-primary collapsed" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h4 class="m-0 font-weight-bold  text-white">Suscripciones</h4>
        </a>

        <div class="collapse" id="collapseCardExample">
            <ul class="list-group list-group-flush border-0">

            @foreach ($user->subscriptions->sortByDesc('created_at') as $subscription)
            <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
                <div class="d-flex justify-content-between mb-1">
                <div class="text-muted small">
                    <i class="bi bi-calendar"></i> Creada el @formattedDateTime($subscription->created_at)
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
            <li class="list-group-item p-3 text-center">
                <button type="button" class="btn btn-sm btn-primary w-75" data-bs-toggle="modal" data-bs-target="#modal-add-subscription">
                Agregar suscripción
                </button>
                <x-admin.modals.add-subscription :user="$user" />
            </li>
            @endcan

            </ul>
        </div>
    </div>

    <div class="card mb-4">
    <a href="#collapseReference" class="d-block card-header py-3 bg-primary collapsed" data-toggle="collapse"
        role="button" aria-expanded="true" aria-controls="collapseReference">
        <h4 class="m-0 font-weight-bold  text-white">Referencias de compra</h4>
    </a>
    <div class="collapse" id="collapseReference">
        <ul class="list-group list-group-flush border-0">

        @foreach ($user->checkout_references->sortByDesc('created_at') as $checkout_reference)
        <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
            <div class="mb-1 text-muted small">
            <i class="bi bi-calendar"></i> Generada el @formattedDateTime($checkout_reference->created_at)
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
    </div>


      <div class="card mb-4">
        <a href="#collapseExams" class="d-block card-header py-3 bg-primary collapsed" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseExams">
            <h4 class="m-0 font-weight-bold  text-white">Exámenes</h4>
        </a>
        <div class="collapse" id="collapseExams">
            <ul class="list-group list-group-flush border-0">

            @foreach ($user->exams->sortByDesc('created_at') as $exam)
            <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
                <div class="mb-1 text-muted small">
                <i class="bi bi-calendar"></i> Iniciado el @formattedDateTime($exam->created_at)
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
      </div>

      <div class="card mb-4">
        <a href="#collapseActivity" class="d-block card-header py-3 bg-primary collapsed" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseActivity">
            <h4 class="m-0 font-weight-bold  text-white">Actividades</h4>
        </a>
        <div class="collapse" id="collapseActivity">
            <ul class="list-group list-group-flush border-0">
            @foreach ($user->activities->sortByDesc('created_at') as $activity)
            <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
                <div class="mb-1 text-muted small">
                <i class="bi bi-calendar"></i> Realizada el @formattedDateTime($activity->created_at)
                </div>
                <div class="mb-1"><b>{{ $activity->activityType->name }}</b></div>
                <div class="small"><span class="text-muted">ID:</span> {{ $activity->id }}</div>
            </li>
            @endforeach
            </ul>
        </div>
      </div>
    </div>
</div>


@endsection
