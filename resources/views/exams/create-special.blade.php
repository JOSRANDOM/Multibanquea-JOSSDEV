@extends('layouts.app')

@section('content')
@php
   $num_max_questions = env('EXAM_SPECIAL_MAX_QUESTIONS',20);
@endphp
<x-title label="Iniciar examen especial" previous-url="{{ route('exams.create') }}" description="Elige duración y cantidad en las subcatergorias que quieres iniciar." />

<main>
    @if (session('success'))
    <x-alert-success message="{{ session('success') }}" />
    @elseif ($errors->any())
    <x-alert-error :errors="$errors->all()" />
    @elseif (session('status'))
    <div class="alert alert-{{ session('status.type') }} alert-dismissible fade show" role="alert">
        <span class="alert-inner--text">{{ session('status.message') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endif
    <form method="POST" action="{{ route('exams.store.especial') }}">
        {{ csrf_field() }}
        <div class="card card-streched-link mb-4">
            <div class="card-body py-2">

                <div class="row">
                    <div class="col-6 pt-2">
                        Preguntas seleccionadas <span id="txtTotal" class="px-2 py-1 bg-success rounded text-white">0</span>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label for="staticEmail" class="col-sm-8 col-form-label text-end"><i class="bi bi-alarm"></i> Duración de examen</label>
                            <div class="col-sm-4">
                                <select name="examTime" class="form-select" id="examTime">
                                    <option value="30">30 min</option>
                                    <option value="60">60 min</option>
                                    <option value="90">90 min</option>
                                    <option value="120">120 min</option>
                                    <option value="240">240 min</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($question_categories as $question_category)
        <div class="card card-streched-link mb-4">
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-12 col-md-6 d-flex gap-3 align-items-md-center">
                        <h3 class=""><i class="bi bi-pencil-fill"></i> {{ $question_category->name }}</h3>
                        <p class="mb-lg-0 text-secondary">
                            {{-- {{ $question_category }} --}}
                        </p>
                    </div>
                </div>
                <div class="row">
                    @foreach ($question_category->question_subcategories as $subcategory)
                    <div class="col-4">
                        <div class="mb-3 row ">
                            <label for="staticEmail" class="col-sm-8 col-form-label text-end">{{ $subcategory->name }}</label>
                            <div class="col-sm-4">
                                {{-- <input type="number" class="form-control text-center " id="staticEmail" min="0" max="20" value="0">--}}
                                <select name="questions[{{ $subcategory->id }}]" class="form-select slcQuestions" >
                                    @for ($i = 0; $i <= $num_max_questions; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>


                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </div>
            </div>

        @endforeach

        <div class="card card-streched-link mb-4">
            <div class="card-body py-2">
                <div class="row">
                    <button class="btn btn-primary w-50 m-auto text-center">Iniciar examen</button>
                </div>
            </div>
        </div>
    </form>

</main>
<script >
$(document).ready(function(){
    $('.slcQuestions').change(function(){
        let total = parseInt(0);
        $(".slcQuestions").each(function() {
            total +=  parseInt($(this ).val());
        });
        $('#txtTotal').html(total)
    })
});
</script>
@endsection
