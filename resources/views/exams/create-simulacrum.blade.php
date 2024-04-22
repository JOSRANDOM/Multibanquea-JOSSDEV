@extends('layouts.app')

@section('content')
    <x-title label="{{ env('SIMULACRUM_CREATE_DETAIL_TITLE','') }}" previous-url="{{ route('exams.create') }}"
             description="{{ env('SIMULACRUM_CREATE_DETAIL_DESCRIPTION','') }}" />

   <main>
    @foreach ($simulacrums as $simulacrum)
    @php
        $is_exist_exam = $simulacrum->examsUSer(Auth::user()->id,$simulacrum->slug);
    @endphp
        <div class="card card-streched-link mb-4">
            <div class="card-body py-lg-5">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
                        <div>
                            <i class="fad fa-seedling fa-fw h1 mt-2"
                               style="--fa-primary-color: #0f9fe2; --fa-secondary-color: #0f9fe2;"></i>
                        </div>
                        <div>
                            <h3>{{ $simulacrum->name}}</h3>
                            <p class="mb-lg-0 text-secondary">
                                @if($is_exist_exam)
                                <strong><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::create($simulacrum->init_at)->format('d/m/Y')  }} </strong><br>
                                @endif
                                {{ $simulacrum->description }}
                                @if(!$is_exist_exam)
                                    @if (now() > $simulacrum->init_at)
                                    <br><b class="text-success"><i class="bi bi-exclamation-triangle"></i> Disponible hasta {{ \Carbon\Carbon::create($simulacrum->end_at)->format('d/m/Y H:i')  }}</b>
                                    @endif
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                        @if(!$is_exist_exam)
                            @if (now() > $simulacrum->init_at)
                                <form method="POST" action="{{ route('exams.store.simulacrum', $simulacrum->slug) }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary stretched-link"><i class="bi bi-clock"></i> Iniciar examen</button>
                                </form>
                            @else
                                <p class="mb-lg-0 text-secondary" style="margin-right: 10px;">
                                    <b>Disponible el {{ \Carbon\Carbon::create($simulacrum->init_at)->format('d/m/Y H:i')  }}</b>
                                </p>
                                <a href="#" class="btn btn-primary stretched-link disabled">
                                    <i class="bi bi-lock-fill"></i> EN ESPERA</a>
                            @endif
                        @else

                        <a href="{{ route('exams.show',[$is_exist_exam->public_id ])}}" class="btn btn-success stretched-link">
                            <i class="bi bi-check2-all"></i> VER RESULTADO</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </main>
@endsection
