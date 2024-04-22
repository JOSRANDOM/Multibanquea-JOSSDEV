@extends('layouts.app')
@section('head.title', 'Academia - ' . config('app.name'))

@section('content')
<x-title label="Academia" previous-url="{{ route('home') }}" description="centro de entrenamiendo dinamico para mejorar tus hábilidades" />

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


    <x-card-recommended-action-academy />
    <x-card-user-academy :user="Auth::user()" />

</main>
@endsection
