@extends('layouts.app')

@section('content')
<x-title label="Iniciar examen estándar" previous-url="{{ route('exams.create') }}"
  description="Elige el tipo de examen estándar que quieras iniciar" />

<main>
  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <div class="fs-1 text-warning">
                <i class="bi bi-thermometer"></i>
            </div>
          </div>
          <div>
            <h3>Pequeño</h3>
            <p class="mb-lg-0 text-secondary">
              10 preguntas
            </p>

            @if (!$user->isSubscribed() && !$user_has_exams_available)
            <div class="alert alert-warning mt-3 mb-lg-0" role="alert">
              <p>Has llegado al límite de exámenes. Podrás crear más el @formattedDate($next_available_exams_date).</p>
              <p class="mb-0">Obtén acceso total a {{ config('app.name') }} para poder iniciar <b>exámenes sin
                  límites</b>.</p>
            </div>
            @endif
          </div>

        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          @if ($user_has_exams_available)
          <form method="POST" action="{{ route('exams.store.standard', 10) }}">
            {{ csrf_field() }}
            <button class="btn btn-primary stretched-link">Iniciar examen</button>
          </form>
          @else
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="btn btn-primary stretched-link"><i
              class="fal fa-lock-alt me-2"></i>Iniciar examen</a>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <div class="fs-1 text-warning">
                <i class="bi bi-thermometer-half"></i>
            </div>
          </div>
          <div>
            <h3>Mediano</h3>
            <p class="mb-lg-0 text-secondary">
              50 preguntas
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">

          @if ($user->isSubscribed())
          <form method="POST" action="{{ route('exams.store.standard', 50) }}">
            {{ csrf_field() }}
            <button class="btn btn-primary stretched-link">Iniciar examen</button>
          </form>
          @else
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="btn btn-primary stretched-link"><i
              class="fal fa-lock-alt me-2"></i>Iniciar examen</a>
          @endif

        </div>
      </div>
    </div>
  </div>

  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <div class="fs-1 text-warning">
                <i class="bi bi-thermometer-high"></i>
            </div>
          </div>
          <div>
            <h3>Grande</h3>
            <p class="mb-lg-0 text-secondary">
              100 preguntas
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">

          @if ($user->isSubscribed())
          <form method="POST" action="{{ route('exams.store.standard', 100) }}">
            {{ csrf_field() }}
            <button class="btn btn-primary stretched-link">Iniciar examen</button>
          </form>
          @else
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="btn btn-primary stretched-link"><i
              class="fal fa-lock-alt me-2"></i>Iniciar examen</a>
          @endif

        </div>
      </div>
    </div>
  </div>
</main>
@endsection
