@extends('layouts.app')

@section('content')
<x-title label="Mi cuenta" previous-url="{{ route('home') }}" description="Estos son los detalles de tu cuenta" />

<main>
  @if (session('success'))
  <x-alert-success message="{{ session('success') }}" />
  @elseif ($errors->any())
  <x-alert-error :errors="$errors->all()" />
  @endif

  <div class="card mb-4">
    <ul class="list-group list-group-flush border-0">

      <li class="list-group-item px-3 py-4 bg-light">
        <div class="mb-1"><b>Nombre</b></div>
        <div class="mb-1">{{ $user->name }}</div>
        <div class="small">
          <a class="text-muted" data-bs-toggle="modal" data-bs-target="#modal-edit-name" href="#modal-edit-name"
            role="button">Cambiar</a>
          <x-modal-edit-user-name />
        </div>
      </li>

      <li class="list-group-item px-3 py-4">
        <div class="mb-1"><b>Correo electrónico</b></div>
        <div>{{ $user->email }}</div>
      </li>

      <li class="list-group-item px-3 py-4 bg-light">
        <div class="mb-1"><b>Fecha de registro</b></div>
        <div>@formattedDate($user->created_at)</div>
      </li>

        <li class="list-group-item px-3 py-4">
            <div class="mb-1"><b>Número teléfono / Celular</b></div>
            <div>{{ $user->phone }}</div>
            <div class="small">
                <a class="text-muted" data-bs-toggle="modal" data-bs-target="#modal-edit-phone" href="#modal-edit-phone"
                   role="button">Cambiar</a>
                <x-modal-edit-user-phone />
            </div>
        </li>

      @if(Auth::user()->study_id!='')
      <li class="list-group-item px-3 py-4">
        <div class="mb-1"><b>Contraseña</b></div>
            <div class="small">
                <a class="text-muted" data-bs-toggle="modal" data-bs-target="#modal-edit-user-password" href="#modal-edit-user-password"
                   role="button">Cambiar</a>
                <x-modal-edit-user-password />
            </div>
      </li>
      @endif


    </ul>
  </div>

  @role('affiliate')
  <div class="card mb-4">
    <div class="card-body border-bottom">
      <h3 class="mb-0">Programa de afiliados</h3>
    </div>
    <ul class="list-group list-group-flush border-0">
      <li class="list-group-item p-3 bg-light">
        <div class="table-responsive">
          <table class="table table-bordered bg-white m-0">
            <thead>
              <tr>
                <th scope="col">Plan</th>
                <th scope="col">Clics</th>
                <th scope="col">Compras</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($analytics as $analytics_item)
              <tr>
                <td>{{ trans_choice('generic.month', $analytics_item->months) }}</td>
                <td>{{ $analytics_item->clicks }}</td>
                <td>{{ $analytics_item->subscriptions }}</td>
              </tr>
              @endforeach

            </tbody>
          </table>
        </div>
      </li>
      <li class="list-group-item px-3 pt-4">
        <div class="mb-3"><b>Enlaces</b></div>
        <div class="mb-3 small">
          <span class="text-muted">General:</span>
          <a href="{{ route('affiliates.show', [$user->slug]) }}"
            target="_blank">{{ route('affiliates.show', [$user->slug]) }}</a>
        </div>
        @foreach ($user->plans as $plan)
        <div class="mb-3 small">
          <span class="text-muted">Oferta de {{ trans_choice('generic.month', $plan->months) }}:</span>
          <a href="{{ route('promo.show', $plan->promo_code) }}" target="_blank">
            {{ route('promo.show', $plan->promo_code) }}
          </a>
        </div>
        @endforeach

      </li>
    </ul>
  </div>
  @endrole

</main>
@endsection
