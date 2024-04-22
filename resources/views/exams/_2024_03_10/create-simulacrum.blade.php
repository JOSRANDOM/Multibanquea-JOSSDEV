@extends('layouts.app')

@section('content')
    <x-title label="Iniciar examen Simulacro" previous-url="{{ route('exams.create') }}"
             description="Elige el tipo de examen simulacro que quieras iniciar" />

   <main>
        <div class="card card-streched-link mb-4">
            <div class="card-body py-lg-5">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
                        <div>
                            <i class="fad fa-seedling fa-fw h1 mt-2"
                               style="--fa-primary-color: #0f9fe2; --fa-secondary-color: #0f9fe2;"></i>
                        </div>
                        <div>
                            <h3>{{ ENV('SIMULACRUM_NAME','Evaluación Diagnóstica Casos 1')}}</h3>
                            <p class="mb-lg-0 text-secondary">
                                {{ $exam_sizes['SIMULACROII'] }} preguntas
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                        <form method="POST" action="{{ route('exams.store.simulacrum', 'SIMULACROII') }}">
                            {{ csrf_field() }}
                            <button class="btn btn-primary stretched-link">Iniciar examen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

       <!--<div class="card card-streched-link mb-4">
            <div class="card-body py-lg-5">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
                        <div>
                            <i class="fad fa-seedling fa-fw h1 mt-2"
                               style="--fa-primary-color: #0f9fe2; --fa-secondary-color: #0f9fe2;"></i>
                        </div>
                        <div>
                            <h3>Examen Final - B</h3>
                            <p class="mb-lg-0 text-secondary">
                                {{ $exam_sizes['SIMULACROII'] }} preguntas
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                        <form method="POST" action="{{ route('exams.store.simulacrum', 'SIMULACROII') }}">
                            {{ csrf_field() }}
                            <button class="btn btn-primary stretched-link">Iniciar examen</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>-->
    </main>
@endsection
