@extends('layouts.admin')
@section('head.title', 'Administración - ' . config('app.name'))

@section('content')
<x-title label="Roles administrativos" description="Administración de roles administrativos"
  previous-url="{{ route('admin.index') }}" />

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
      <h3 class="mb-3">{{ $users->count() }} usuarios con roles administrativos</h3>
      <div>Hay {{ $roles->count() }} roles administrativos disponibles: {{ $roles->pluck('name')->implode(', ') }}</div>
    </div>
  </div>

  <button type="button" class="btn btn-lg btn-outline-light mb-4" data-bs-toggle="modal" data-bs-target="#modal-new">
    <span class="fal fa-fw fa-plus me-2"></span>Asignar rol a usuario
  </button>

  <div class="card mb-4">
    <ul class="list-group list-group-flush border-0">

      @foreach ($users as $user)
      <li class="list-group-item p-3 {{ $loop->odd ? 'bg-light' : ''}}">
        <div class="d-flex mt-2 align-items-center">
          <div
            class="d-flex flex-shrink-0 me-3 border border-secondary rounded-circle align-items-center justify-content-center bg-light"
            style="height: 32px; width: 32px;">

            @if ($user->o_auth_users->first())
            <img src="{{ $user->o_auth_users->first()->avatar }}" class="img-fluid rounded-circle">
            @else
            <span class="fal fa-user"></span>
            @endif

          </div>
          <div class="w-100">
            <div class="mb-1">

              @foreach($user->roles as $user_role)
              <div class="badge bg-warning fw-normal">{{ $user_role->name }}</div>
              @endforeach

            </div>
            <div class="mb-1"><b>{{ $user->name }}</b></div>
            <div class="mb-1 small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
            <div class="mb-1 small"><span class="text-muted">Correo electrónico:</span> {{ $user->email }}</div>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
              data-bs-target="#modal-edit-{{ $user->id }}">Editar</a>
          </div>
        </div>
      </li>

      {{-- Edit user role modal -----------------------------------------------------}}
      <div class="modal fade" id="modal-edit-{{ $user->id }}" tabindex="-1" aria-labelledby="modal-edit-{{ $user->id }}"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <form method="POST" action="{{ route('admin.roles.update') }}">
              @csrf
              @method('PUT')
              <div class="modal-header border-0">
                <h5 class="modal-title" id="modal-edit-{{ $user->id }}-label">Editar roles de usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <div><b>{{ $user->name }}</b></div>
                  <div class="small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
                  <div class="small"><span class="text-muted">Correo electrónico:</span> {{ $user->email }}</div>
                  <input name="user" value="{{ $user->id }}" hidden>
                </div>
                <hr>
                <div class="mb-3">
                  <label class="form-label">Roles</label>

                  @foreach($roles as $role)
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="roles[]"
                      id="check-role-{{ $user->id }}-{{ $role->id }}" value="{{ $role->name }}"
                      @if($user->hasRole($role->name)) checked @endif>
                    <label class="form-check-label" for="check-role-{{ $user->id }}-{{ $role->id }}">
                      {{ $role->name }}
                    </label>
                  </div>
                  @endforeach

                </div>
              </div>
              <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Aceptar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endforeach

    </ul>
  </div>
</main>

{{-- New user role modal -----------------------------------------------------}}
<div class="modal fade" id="modal-new" tabindex="-1" aria-labelledby="modal-new" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.roles.store') }}">
        @csrf
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-new-label">Asignar rol a usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="input-user" class="form-label">ID del usuario</label>
            <input type="number" class="form-control" id="input-user" name="user" required>
          </div>
          <div class="mb-3">
            <label for="select-role" class="form-label">Rol</label>
            <select id="select-role" class="form-select" name="role" required>

              @foreach($roles as $role)
              <option value="{{ $role->name }}">{{ $role->name }}</option>
              @endforeach

            </select>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
