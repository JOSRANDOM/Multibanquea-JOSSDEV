@extends('layouts.app')

@section('content')
<x-title label="{{ $question_category->name }}" previous-url="{{ route('statistics.index') }}" description="Éste es el progreso de tu rendimiento en esta categoría" />

<main>
  <x-card-user-exams-score-progress :chartData="$chart_data" headline="Progreso de puntuación en {{ Str::lower($question_category->name) }}" :user="Auth::user()" />

  @if (!Auth::user()->isSubscribed())
  <x-card-upgrade />
  @endif

  <x-card-user-subcategories-progress :questionCategory="$question_category" :user="Auth::user()" />
</main>
@endsection
