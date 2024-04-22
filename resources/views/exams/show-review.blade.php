@extends('layouts.app')
@section('head.title', 'Examen - ' . config('app.name'))

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
<x-title label="{{ $exam_name }}" previous-url="{{ route('exams.index') }}" description="Examen completado" />

<main>

  @if (session('success'))
  <x-alert-success message="{{ session('success') }}" />
  @endif

  <div class="row">
    <div class="col-12 col-lg-6 col-xl-5 order-lg-1">
      <x-card-user-exam-completed-details :exam="$exam" />

      @if (!Auth::user()->isSubscribed())
      <x-card-upgrade />
      @endif

      <x-card-perfomance-user />
    </div>
    <div class="col-12 col-lg-6 col-xl-7 order-lg-0">
      <x-card-user-exam-completed-questions :exam="$exam" />
    </div>
  </div>
</main>
@endsection
