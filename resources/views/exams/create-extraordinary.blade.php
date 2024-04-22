@extends('layouts.app')

@section('content')
    <x-title label="{{ env('exam_CREATE_DETAIL_TITLE','') }}" previous-url="{{ route('exams.create') }}"
             description="{{ env('exam_CREATE_DETAIL_DESCRIPTION','') }}" />

   <main>
    @foreach ($exams as $exam)
    @php
        $is_exist_exam = $exam->countExamsUSer(Auth::user()->id,$exam->slug);
        $is_exist_exam_active = $exam->examsActiveUSer(Auth::user()->id,$exam->slug);
        
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
                            <h3>{{ $exam->name}} <span>({{ $is_exist_exam }} de {{ $exam->amount }})</span></h3>
                            <p class="mb-lg-0 text-secondary">
                                @if($is_exist_exam ==$exam->amount )
                                <strong><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::create($exam->init_at)->format('d/m/Y')  }} </strong><br>
                                @endif
                                {{ $exam->description }}
                                @if($is_exist_exam != $exam->amount)
                                    @if (now() > $exam->init_at)
                                    <br><b class="text-success"><i class="bi bi-exclamation-triangle"></i> Disponible hasta {{ \Carbon\Carbon::create($exam->end_at)->format('d/m/Y H:i')  }}</b>
                                    @endif
                                @endif
                                
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 d-flex align-items-center justify-content-end">
                        @if($is_exist_exam != $exam->amount)
                            @if (now() > $exam->init_at)
                            @if($is_exist_exam == $exam->amount )
                                {{-- <p class="mb-lg-0 text-secondary" style="margin-right: 10px;">
                                    <b>Disponible el {{ \Carbon\Carbon::create($exam->init_at)->format('d/m/Y H:i')  }}</b>
                                </p> --}}
                                <a href="#" class="btn btn-primary stretched-link disabled">
                                    <i class="bi bi-check2-circle"></i> COMPLETADO</a>
                            @else                            
                                <form method="POST" action="{{ route('exams.store.extraordinary', $exam->slug) }}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary stretched-link"><i class="bi bi-clock"></i> Iniciar examen #{{ $is_exist_exam + 1 }}</button>
                                </form> 
                            @endif
                            @else
                                <p class="mb-lg-0 text-secondary" style="margin-right: 10px;">
                                    <b>Disponible el {{ \Carbon\Carbon::create($exam->init_at)->format('d/m/Y H:i')  }}</b>
                                </p>
                                <a href="#" class="btn btn-primary stretched-link disabled">
                                    <i class="bi bi-lock-fill"></i> EN ESPERA</a>
                            @endif
                        @else

                        <a href="{{ route('exams.index')}}" class="btn btn-success stretched-link">
                            <i class="bi bi-check2-all"></i> VER RESULTADOS</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </main>
@endsection
