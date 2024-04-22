@extends('layouts.app')

@section('content')
<x-title label="Iniciar examen realista" previous-url="{{ route('exams.create') }}"
  description="Elige el tipo de examen realista que quieras iniciar" />

<main>
  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
              <div class="fs-1 text-info">
                <i class="bi bi-thermometer"></i>
            </div>
          </div>
          <div>
            <h3>Pequeño</h3>
            <p class="mb-lg-0 text-secondary">
              {{ $exam_sizes['SMALL'] }} preguntas
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          <form method="POST" action="{{ route('exams.store.balanced', 'SMALL') }}">
            {{ csrf_field() }}
            <button class="btn btn-primary stretched-link">Iniciar examen</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <div class="fs-1 text-info">
                <i class="bi bi-thermometer-half"></i>
            </div>
          </div>
          <div>
            <h3>Normal</h3>
            <p class="mb-lg-0 text-secondary">
              {{ $exam_sizes['NORMAL'] }} preguntas
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          <form method="POST" action="{{ route('exams.store.balanced', 'NORMAL') }}">
            {{ csrf_field() }}
            <button class="btn btn-primary stretched-link">Iniciar examen</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
