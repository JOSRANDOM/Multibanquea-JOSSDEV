@extends('layouts.app')

@section('content')
<x-title label="Iniciar examen de categoría" previous-url="{{ route('exams.create') }}" description="Elige el tipo de examen de categoría que quieras iniciar" />

<main>

  @foreach ($question_categories as $question_category)
  <div class="card card-streched-link mb-4">
    <div class="card-body py-lg-5">
      <div class="row">
        <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
          <div>
            <i class="fad fa-pencil-alt fa-fw h1 mt-2"
              style="--fa-primary-color: #09bd27; --fa-secondary-color: #09bd27;"></i>
              <div class="fs-1 text-success">
                <i class="bi bi-pencil-square"></i>
              </div>
          </div>
          <div>
            <h3>{{ $question_category->name }}</h3>
            <p class="mb-lg-0 text-secondary">
              25 preguntas
            </p>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
          <form method="POST" action="{{ route('exams.store.category', $question_category) }}">
            {{ csrf_field() }}
            <button class="btn btn-primary stretched-link">Iniciar examen</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

</main>
@endsection
