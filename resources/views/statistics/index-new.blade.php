@extends('layouts.app')
@section('main-class', '')
@section('content')
<x-title label="{{ __('statistics.stats_title') }}" previous-url="{{ route('home') }}" description="Éste es el progreso de tu rendimiento" />
<main>

  {{-- <x-card-user-exams-score-progress :chartData="$chart_data" headline="Progreso general de puntuación" :user="Auth::user()" /> --}}

  @if (!Auth::user()->isSubscribed())
  <x-card-upgrade />
  @endif

  <x-card-user-stats-summary />
  <x-card-user-datatable-summary />
  {{-- <x-card-user-categories-progress :user="Auth::user()" /> --}}
</main>
@endsection
