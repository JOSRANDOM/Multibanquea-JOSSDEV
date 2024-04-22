@extends('layouts.admin')
@section('head.title', 'Administración - ' . config('app.name'))

@section('content')
<x-title label="Afiliados" description="Administración de participantes del programa de afiliados" previous-url="{{ route('admin.index') }}" />

<main class="container-lg ml-0 px-0">
  @if (session('success'))
  <x-alert-success message="{{ session('success') }}" />
  @elseif ($errors->any())
  <x-alert-error :errors="$errors->all()" />
  @endif

  <button type="button" class="btn btn-lg btn-outline-light mb-4" data-bs-toggle="modal" data-bs-target="#modal-add-affiliate">
    <span class="fal fa-fw fa-plus me-2"></span>Agregar un afiliado
  </button>
  <x-admin.modals.add-affiliate />

  <div class="card mb-4">
    <div class="card-body border-bottom pb-0">
      <h3 class="mb-3">Afiliados activos</h3>
    </div>
    <ul class="list-group list-group-flush border-0">

      @foreach ($affiliates as $user)
      <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
        <div class="d-flex mt-2 align-items-center">
          <div class="d-flex flex-shrink-0 me-3 border border-secondary rounded-circle align-items-center justify-content-center bg-light" style="height: 32px; width: 32px;">

            @if ($user->o_auth_users->first())
            <img src="{{ $user->o_auth_users->first()->avatar }}" class="img-fluid rounded-circle">
            @else
            <span class="fal fa-user"></span>
            @endif

          </div>
          <div class="w-100">
            <div class="mb-1"><b>{{ $user->name }}</b></div>
            <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
            <div class="mb-1 small"><span class="text-muted">Identificador público:</span> {{ $user->slug }}</div>
            <div class="mb-1 small"><span class="text-muted">Correo electrónico:</span> {{ $user->email }}</div>
            <div class="mb-1 small"><span class="text-muted">Clics:</span> {{ $analytics->where('user_id', $user->id)->first()->clicks }}</div>
            <div class="mb-2 small"><span class="text-muted">Compras:</span> {{ $analytics->where('user_id', $user->id)->first()->subscriptions }}</div>
            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-deactivate-affiliate-{{ $user->id }}" class="btn btn-sm btn-outline-primary">Desactivar</button>
            <x-admin.modals.remove-affiliate :user="$user" />
            <button type="button" data-bs-toggle="modal" data-bs-target="#modal-edit-user-slug-{{ $user->id }}" class="btn btn-sm btn-primary">Cambiar identificador público</button>
            <x-admin.modals.edit-user-slug :user="$user" />
          </div>
        </div>
      </li>
      @endforeach

    </ul>
  </div>
</main>
@endsection
