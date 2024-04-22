@extends('layouts.app')

@section('content')
<x-title label="{{ __('statistics.statistic') }}" previous-url="{{ route('home') }}" description="Éste es el progreso de tu rendimiento" />

<main>
  <x-card-user-exams-score-progress :chartData="$chart_data" headline="Progreso general de puntuación" :user="Auth::user()" />

  @if (!Auth::user()->isSubscribed())
  <x-card-upgrade />
  @endif

  <x-card-user-progress-summary :user="Auth::user()" />
  <x-card-user-categories-progress :user="Auth::user()" />
</main>
@endsection
