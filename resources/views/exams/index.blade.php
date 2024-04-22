@extends('layouts.app')
@section('head.title', 'Exámenes - ' . config('app.name'))

@section('content')
<x-title label="Exámenes" previous-url="{{ route('home') }}" description="Éstos son los exámenes que has iniciado" />

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

  @if(!Auth::user()->hasExamInProgress())
          @if($user->phone!='')
              <a href="{{ route('exams.create') }}" class="btn btn-lg btn-outline-light mb-4">
                  <span class="fal fa-fw fa-plus me-2"></span>Iniciar examen
              </a>
          @else
              <a href="#modal-user-update-phone" class="btn btn-lg btn-outline-light mb-4" data-bs-toggle="modal" data-bs-target="#modal-user-update-phone">
                  <span class="fal fa-fw fa-plus me-2"></span>Iniciar examen
              </a>

          @endif
  @endif

  <x-card-user-exams :user="Auth::user()" />
  <x-modal-user-update-phone />
</main>
@endsection
