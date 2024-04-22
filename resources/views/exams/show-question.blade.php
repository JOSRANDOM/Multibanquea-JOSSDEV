@extends('layouts.app')
@section('page-script')
    @include('layouts.countdown')
@endsection
@section('content')
@php
  $exam_name = '';
  // ($exam->simulacrum) ? $exam->simulacrum_data->name : __('exams.types.' . $exam->type)
  if($exam->type =='EXTRAORDINARY'){
    $exam_name =  $exam->extraordinary_data->name;
  }else if($exam->type =='SIMULACRUM' && $exam->simulacrum){
    $exam_name =  $exam->simulacrum_data->name;
  }else{
    $exam_name =  __('exams.types.' . $exam->type);
  }


@endphp
<x-title label="Pregunta {{ $question_number }} de {{ $question_count }}" previous-url="{{ route('exams.show', $exam) }}" description="{{ $exam_name }} de {{ $exam->questions()->count() }} preguntas" />

<main>

   @if( session()->has('exam_expiration_time'))
   <div class="row">
       <div class="col-12 col-lg-12 col-xl-12">
           <div class="timer-question-container exam-timer">
            <span id="countdown_exam" class="countdown"></span>
                <i id="countdown_icon" class="far fa-alarm-clock fa-2x"></i>
           </div>
       </div>
   </div>
   @endif

  <div class="row">
    <div class="col-12 col-lg-6 col-xl-7">

      @if (session('success'))
      <x-alert-success message="{{ session('success') }}" />
      @endif
      <question answer="{{ $answer_response->answer_id }}" exam="{{ $exam->public_id }}" next-question-url="{{ $next_question_url }}" :question="{{ $question->id }}" question-text="{{ $question->text }}"></question>
      {{-- //quitar view --}}
    </div>

    <div class="col-12 col-lg-6 col-xl-5">
      <x-card-report-question-problem :question="$question" :user="Auth::user()" />
        {{-- questions --}}
        <div class="card card-body bg-dark mb-4">
            <div class="accordion accordion-flush" id="accordionFlushExample">
              <div class="accordion-item text-white">
                <h2 class="accordion-header" id="flush-headingOne">
                  <button class="p-0 accordion-button collapsed " style="background-color: transparent!important;border:0px" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <span class="text-white">VER PREGUNTAS</span>
                  </button>
                </h2>

                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                    <div class="row justify-content-start my-3">

                        @php $i = 0 @endphp
                        @foreach ($exam->questions as $question_info)
                        @php $i++ @endphp
                        <div class="col-3 text-center mb-3">
                            <a href="{{ route('exams.show.question',[$exam, $question_info]) }}" class="btn color-white w-100 {{ ($question->id== $question_info->id ? 'btn-primary disabled' : ( ($question_info->pivot->answer_id) ? 'btn-success' : 'btn-light') ) }}">
                                {{ $i }}
                            </a>
                        </div>
                        @if ($question_info->pivot->answer_id)

                        @else

                        @endif
                        @endforeach
                    </div>
                </div>
              </div>


            </div>
        </div>
        {{-- end questions --}}

      <x-card-question-details :difficulty="$question_difficulty" :question="$question" />
      <x-card-user-exam-progress :exam="$exam" />

        {{-- <form method="POST" action="{{ route('exams.save.note', [$exam, $question]) }}">--}}

            {{-- @csrf --}}
            {{-- <div class="form-row note-form">
                <button type="submit" class="btn btn-primary-2">Guardar</button>
                <input type="text" name="question_note" placeholder="Comentarios por respuestas" class="form-control input-question" value="{{ $note }}" >
            </div> --}}
        {{-- </form> --}}

    </div>
  </div>
</main>
@endsection
