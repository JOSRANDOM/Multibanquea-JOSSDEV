@extends('layouts.admin')
@section('head.title', 'Administración - ' . config('app.name'))

@section('content')
<x-title label="Usuarios" description="Administración de usuarios" previous-url="{{ route('admin.index') }}" />

<main class="container-lg ml-0 px-0">
  @if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="alert-inner--text">{{ session('status') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <div class="card mb-4">
    <div class="card-body">
      <h3 class="mb-3">{{ $users->total() }} usuarios</h3>
      <div>En esta semana se han registrado {{ $users_registered_last_week }} nuevos usuarios.</div>
    </div>
  </div>

   <form action="{{ route('admin.users.index') }}" method="GET" role="search" class="form-inline">
          <input type="text" class="search-promo-code mb-4 float-right" placeholder="Buscar usuario" name="term" id="term" value="{{ $term ?? '' }}">
          <button class="btn btn-info btn-lg mb-4 btn-search-code" type="submit" title="Buscar">BUSCAR</button>
   </form>

  <div class="card mb-3">
    <div class="card-body border-bottom pb-0">
      <h3 class="mb-3">Usuarios</h3>
      <div class="d-block d-lg-flex align-items-center justify-content-between gap-3">
        <div>
          <div class="btn-group me-3">
            <button class="btn btn-outline-secondary dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Ordenar por...
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => 'name']) }}">Nombre</a></li>
              <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => 'email']) }}">Correo electrónico</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => 'id']) }}">ID</a></li>
              <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => 'created_at']) }}">Fecha de registro</a></li>
                <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => 'study_id', 'orderDirection' => 'desc']) }}">Tipo de Usuario</a></li>
            </ul>
          </div>
          <div class="btn-group">
            <button class="btn btn-outline-secondary dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              En dirección...
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => $orderBy, 'orderDirection' => 'asc']) }}">Ascendente</a></li>
              <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => $orderBy, 'orderDirection' => 'desc']) }}">Descendente</a></li>
            </ul>
          </div>
        </div>

        @if ($users->hasPages())
        {{ $users->links() }}
        @endif

      </div>
    </div>

    <ul class="list-group list-group-flush border-0">

      @foreach ($users as $user)
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
            <div class="d-flex justify-content-between mb-1">
              <div class="text-muted small">
                <i class="fal fa-calendar-alt me-2"></i>Registrado el @formattedDate($user->created_at)
              </div>
              @if ($user->isSubscribed())
              <div class="badge bg-warning fw-normal">Suscripción activa</div>
              @endif
            </div>
            <div class="mb-1"><b>{{ $user->name }}</b></div>
            <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
            <div class="mb-1 small"><span class="text-muted">Correo electrónico:</span> {{ $user->email }}</div>
            @if ($user->utm_medium || $user->utm_source || $user->utm_campaign || $user->utm_term || $user->utm_content)
            <div class="mb-1 small">
              <span class="text-muted">Atribución:</span>
              {{ $user->utm_medium }} {{ $user->utm_source }} {{ $user->utm_campaign }} {{ $user->utm_term }}
              {{ $user->utm_content }}
            </div>
            @endif
              <div class="d-flex justify-content-between mb-1">
                  <div class="text-muted small">
                      <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-primary">Ver detalles</a>
                  </div>
                  @if ($user->study_id!='')
                  <div class="badge bg-success fw-normal" style="height: 20px!important;">Cuenta de Estudiante</div>
                  @endif
              </div>


          </div>
        </div>
      </li>
      @endforeach

    </ul>

    @if ($users->hasPages())
    <div class="card-body border-top pb-0">
      {{ $users->links() }}
    </div>
    @endif
  </div>
</main>
@endsection
