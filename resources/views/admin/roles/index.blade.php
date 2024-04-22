@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Roles administrativos</h1>
</div>
@if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
<div class="card mb-4">
    <div class="card-body">
      <h3 class="mb-3">{{ $total }} usuarios con roles administrativos</h3>
      <div>Hay {{ $roles->count() }} roles administrativos disponibles: {{ $roles->pluck('name')->implode(', ') }}</div>
    </div>
</div>
<div class="card mb-4">
    <div class="card-body">
        <h5>
            Listado de usuario
            <button type="button" class="btn btn-outline-dark float-end" data-bs-toggle="modal" data-bs-target="#modal-new">
                <i class="bi bi-plus"></i> Asignar rol a usuario
            </button>
        </h5>
        <div class="table-responsive">
            @if ($users->hasPages())
                {{ $users->links() }}
            @endif
            <table class="table table-hover ">
                <thead>
                    <tr>

                        <th class="text-center">ID</th>
                        <th class="text-center">IMG</th>
                        <th class="text-center">REGISTRO</th>
                        <th>NOMBRE</th>
                        <th>CORREO</th>
                        <th>ROLES</th>
                        <th class="text-center"> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="text-center align-middle">{{ $user->id }}</td>
                        <td class="text-center align-middle">
                            <div class="border border-secondary rounded-circle bg-light m-auto" style="height: 32px; width: 32px;">
                                @if ($user->o_auth_users->first())
                                    <img src="{{ $user->o_auth_users->first()->avatar }}" class="img-fluid rounded-circle">
                                @else
                                    <i class="bi bi-person-fill"></i>
                                @endif
                            </div>
                        </td>
                        <td>
                            <i class="bi bi-calendar"></i> @formattedDate($user->created_at)<br>
                            <i class="bi bi-clock"> @formattedTime($user->created_at)</i>
                        </td>
                        <td class="align-middle">{{ $user->name }}</td>
                        <td class="align-middle">{{ $user->email }}</td>
                        <td class="align-middle">
                            @foreach($user->roles as $user_role)
                                <div class="badge bg-success fw-normal">{{ $user_role->name }}</div>
                            @endforeach
                        </td>
                        <td class="align-middle">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $user->id }}"><i class="bi bi-pencil-square"></i> Editar</button>
                            <div class="modal fade" id="modal-edit-{{ $user->id }}" tabindex="-1" aria-labelledby="modal-edit-{{ $user->id }}"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered ">
                                  <div class="modal-content ">
                                    <form method="POST" action="{{ route('admin.roles.update') }}">
                                      @csrf
                                      @method('PUT')
                                      <div class="modal-header border-0">
                                        <h5 class="modal-title" id="modal-edit-{{ $user->id }}-label">Editar roles de usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                      </div>
                                      <div class="modal-body ">
                                        <div class="mb-3">
                                          <h3>{{ $user->name }}</h3>
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

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($users->hasPages())
                {{ $users->links() }}
            @endif
        </div>
    </div>
  </div>
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
