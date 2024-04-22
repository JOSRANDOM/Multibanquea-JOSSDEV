@extends('layouts.app')

@section('content')
<x-title label="Iniciar examen" previous-url="{{ route('exams.index') }}"
  description="Elige el tipo de examen que quieras iniciar" />

<main>

  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
              <div class="fs-1 text-warning">
                <i class="bi bi-journal-check"></i>
              </div>
          </div>
          <div>
            <h3>Examen estándar</h3>
            <p class="mb-lg-0 text-secondary">
              Preguntas de todas las categorias y distribución aleatoria.
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          <a href="{{ route('exams.create.standard') }}" class="btn btn-primary stretched-link">Seleccionar</a>
        </div>
      </div>
    </div>
  </div>

    @if ($simulacrum_switch)
    <div class="card card-streched-link mb-4">
        <div class="card-body py-lg-5">
            <div class="row">
                <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
                    <div>
                        <i class="fad fa-siren fa-fw h1 mt-2"
                           style="--fa-primary-color: #ff0a0a; --fa-secondary-color: #de0505;"></i>
                           <div class="fs-1 text-dark">
                            <i class="bi bi-journal-check"></i>
                          </div>
                    </div>
                    <div>
                        <h3>Examen Simulacro</h3>
                        <p class="mb-lg-0 text-secondary">

                            Tiene un tiempo de 90 minutos y es de un solo intento, una vez iniciado no podrá ser cancelado.
                        </p>
                    </div>
                </div>
                <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                    @if ($simulacrum_available)
                        <a href="{{ route('exams.create.simulacrum') }}" class="btn btn-primary stretched-link">
                            Seleccionar</a>
                    @else
                        <p class="mb-lg-0 text-secondary" style="margin-right: 10px;">
                            <b>Disponible el {{ $simulacrum_date  }}</b>
                        </p>
                        <a href="{{ route('exams.create.simulacrum') }}" class="btn btn-primary stretched-link disabled">
                            <i class="fal fa-lock-alt me-2"></i>Seleccionar</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <i class="fad fa-user-graduate fa-fw h1 mt-2"
              style="--fa-primary-color: #0f9fe2; --fa-secondary-color: #0f9fe2;"></i>
              <div class="fs-1 text-info">
                <i class="bi bi-journal-check"></i>
              </div>
          </div>
          <div>
            <h3>Examen realista</h3>
            <p class="mb-lg-0 text-secondary">
              Preguntas distribuidas de manera similar a un examen real.
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          @if ($user->isSubscribed())
          <a href="{{ route('exams.create.balanced') }}" class="btn btn-primary stretched-link">Seleccionar</a>
          @else
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="btn btn-primary stretched-link"><i
              class="fal fa-lock-alt me-2"></i>Seleccionar</a>
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
            <div class="fs-1 text-success">
                <i class="bi bi-journal-check"></i>
              </div>
            <i class="fad fa-book-alt fa-fw h1 mt-2"
              style="--fa-primary-color: #09bd27; --fa-secondary-color: #09bd27;"></i>
          </div>
          <div>
            <h3>Examen de categoría</h3>
            <p class="mb-lg-0 text-secondary">
              Preguntas de una categoría específica.
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          @if ($user->isSubscribed())
          <a href="{{ route('exams.create.category') }}" class="btn btn-primary stretched-link">Seleccionar</a>
          @else
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="btn btn-primary stretched-link"><i
              class="fal fa-lock-alt me-2"></i>Seleccionar</a>
          @endif
        </div>
      </div>
    </div>
  </div>
{{-- NUEVO EXAMEN --}}
  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <div class="fs-1 text-danger">
                <i class="bi bi-journal-check"></i>
              </div>
          </div>
          <div>
            <h3>Examen especial</h3>
            <p class="mb-lg-0 text-secondary">
              Preguntas dinamicas por categorías y subcategoria.
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          @if ($user->isSubscribed())
          <a href="{{ route('exams.create.especial') }}" class="btn btn-primary stretched-link">Seleccionar</a>
          @else
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="btn btn-primary stretched-link"><i
              class="fal fa-lock-alt me-2"></i>Seleccionar</a>
          @endif
        </div>
      </div>
    </div>
  </div>


</main>
@endsection
