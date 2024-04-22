@extends('layouts.app')
@section('head.title', 'Examen - ' . config('app.name'))

@section('page-script')
    @include('layouts.countdown')
@endsection

@php
  $exam_name = '';
  // ($exam->simulacrum) ? $exam->simulacrum_data->name : __('exams.types.' . $exam->type)
  if($exam->type =='EXTRAORDINARY'){
    $exam_name =  $exam->extraordinary_data->name;
  }else if($exam->type =='SIMULACRUM' && $exam->simulacrum ){
    $exam_name =  $exam->simulacrum_data->name;
  }else{
    $exam_name =  __('exams.types.' . $exam->type);
  }


@endphp
@section('content')
<x-title label="{{  $exam_name }}" previous-url="{{ route('exams.index') }}"
  description="Examen en progreso" />

<main>
    <div class="row">
        <div class="col-7">

  @if ($exam->getNextUnansweredQuestion())
  <a href="{{ route('exams.show.question', [$exam, $exam->getNextUnansweredQuestion()]) }}"
    class="btn btn-lg btn-outline-light mb-4">
    Continuar respondiendo
  </a>

  @endif
        </div>

        <div class="col-5">

      <div class="exam-timer">
          @if( session()->has('exam_expiration_time'))
              <span id="countdown_exam" class="countdown"></span>
              <i id="countdown_icon" class="far fa-alarm-clock fa-2x"></i>
          @endif

          @if(!$exam->answered_questions()->count() && !session()->has('exam_expiration_time'))
              <a href="{{ route('exams.countdown', $exam) }}" class="btn btn-danger btn-lg">
              <span class="tooltip-toggle" aria-label="Utiliza nuestro nuevo cronómetro para resolver el examen antes de que se termine el tiempo!" tabindex="0">
                  <i class="fa fa-info-circle" aria-hidden="true"></i>
              </span>
                  Ponte a prueba! haz clic aquí </a>
          @endif
      </div>
        </div>
    </div>

  @if (!$exam->unanswered_questions()->count())
      <div class="row">
  <div class="alert alert-success mb-4" role="alert">
    <form method="POST" action="{{ route('exams.finish', $exam) }}">
      {{ csrf_field() }}
      <p>Has respondido todas las preguntas.</p>
      <button class="btn btn-lg btn-primary">Calificar examen</button>
    </form>
  </div>
      </div>
  @endif

  <div class="row">
    <div class="col-12 col-lg-6 col-xl-5 order-lg-1">
        <x-card-user-exam-progress :exam="$exam" />
        {{-- questions --}}
        <div class="card card-body bg-dark mb-4">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item text-white">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed p-0 " style="background-color: transparent!important;border:0px" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <span class="text-white">VER PREGUNTAS</span>
                    </button>
                </h2>

                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="row justify-content-start my-3">

                        @php $i = 0 @endphp
                        @foreach ($exam->questions as $question_info)
                        @php $i++ @endphp
                        <div class="col-3 text-center mb-3">
                            <a href="{{ route('exams.show.question',[$exam, $question_info]) }}" class="btn color-white w-100 {{ ($question_info->pivot->answer_id) ? 'btn-success' : 'btn-light'  }}">
                                {{ $i }}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                </div>


            </div>
        </div>
        {{-- end questions --}}
      @if (!Auth::user()->isSubscribed())
      <x-card-upgrade />
      @endif

    </div>
    <div class="col-12 col-lg-6 col-xl-7 order-lg-0">
      <x-card-user-exam-questions :exam="$exam" />
    </div>
  </div>
</main>
@endsection
