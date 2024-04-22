@extends('layouts.app')
@section('head.title', 'Estadísticas detalle  - ' . config('app.name'))
@section('main-class', '')
@section('content')
<x-title label="{{ __('exams.types.' . $exam->type) }} {{ ($exam->type === 'CATEGORY') ? '('. $exam->question_category->name. ')' : ''  }}" previous-url="{{ route('statistics.index.new') }}" description="fecha : {{ \Carbon\Carbon::parse($exam->created_at)->format('d/m/Y h:i a') }}" />
<main>
    <div class="row">
        <x-card-user-stats-exam-detail :exam="$exam" />
        @if($exam->type != 'SPECIAL')
            <x-card-user-stats-ranking  :exam="$exam" />
        @endif
    </div>
</main>
@endsection
