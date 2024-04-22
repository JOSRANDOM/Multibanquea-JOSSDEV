@extends('layouts.madmin')
@section('content')
<h1 class="h3 mb-1 text-gray-800 w-100">Usuarios</h1>
<p class="mb-4">Administración de usuarios.</p>
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
<div class="card mb-3">
    <div class="card-body border-bottom pb-0">
      <h3 class="mb-3">Usuarios</h3>
        {{-- <div class="d-block d-lg-flex align-items-center justify-content-between gap-3"> --}}
        <div class="row mb-4">
            <div class="col-lg-3">
                <div class="btn-group me-3 w-100">
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
            </div>
            <div class="col-lg-3">
                  <div class="btn-group w-100">
                      <button class="btn btn-outline-secondary dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          En dirección...
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => $orderBy, 'orderDirection' => 'asc']) }}">Ascendente</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.users.index', ['orderBy' => $orderBy, 'orderDirection' => 'desc']) }}">Descendente</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('admin.users.index') }}" method="GET" role="search" class="w-100">
                        {{-- <input type="text" class="search-promo-code mb-4 float-right" placeholder="Buscar usuario" name="term" id="term" value="{{ $term ?? '' }}">
                        <button class="btn btn-info btn-lg mb-4 btn-search-code" type="submit" title="Buscar">BUSCAR</button> --}}

                        <div class="input-group">
                            <input type="text" name="term" id="term" value="{{ $term ?? '' }}" class="form-control bg-light border-0 small" placeholder="Buscar usuario" aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


        {{-- </div> --}}
        {{-- </div> --}}
        @if ($users->hasPages())
        {{ $users->links() }}
        @endif
        <div class="table-responsive">
            <table class="table table-striped table-sm table-bordered dataTable">
                <thead class="">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">IMG</th>
                        <th class="text-center">REGISTRO</th>
                        <th class="text-center">NOMBRE</th>
                        <th class="text-center">CORREO</th>
                        <th class="text-center">TELÉFONO</th>
                        <th class="text-center">SUBSCRRIPCIÓN</th>
                        <th class="text-center">CUENTA</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->id }}</td>
                            <td class="text-center">
                                <div class="border border-secondary rounded-circle bg-light m-auto" style="height: 32px; width: 32px;">
                                    @if ($user->o_auth_users->first())
                                        <img src="{{ $user->o_auth_users->first()->avatar }}" class="img-fluid rounded-circle">
                                    @else
                                        <i class="bi bi-person-fill"></i>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @formattedDate($user->created_at)
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td class="text-center">
                                @if ($user->isSubscribed())
                                    <div class="badge bg-success fw-normal px-3 text-white">Suscripción activa</div>
                                @else
                                    <div class="badge bg-danger fw-normal px-3 text-white">Suscripción inactiva</div>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($user->study_id!='')
                                    <div class="badge bg-dark fw-normal px-3 text-white">Cuenta de Estudiante</div>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye-fill"></i> detalles</a>
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
@endsection
