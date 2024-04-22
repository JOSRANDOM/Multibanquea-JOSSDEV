@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Código promocionales</h1>
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
        <h3 class="mb-3">Listado {{ $status == 'active' ? 'activos' : ($status == 'inactive' ? 'inactivos' : '') }} ( {{ $total }} )</h3>
        <div class="row mb-4">
            <div class="col-lg-2">
                <div class="btn-group me-3 w-100">
                    <button class="btn btn-outline-secondary dropdown-toggle mb-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Seleccione estado
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.promo-codes.index', ['status' => 'all']) }}">Todos</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.promo-codes.index', ['status' => 'active', 'term' => ($term ?? '')]) }}">Activos</a></li>
                      <li><a class="dropdown-item" href="{{ route('admin.promo-codes.index', ['status' => 'inactive','term' => ($term ?? '')]) }}">Inactivos</a></li>
                    </ul>
                  </div>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#modal-new">
                    <i class="bi bi-plus"></i> Crear nuevo
                </button>
            </div>
            <div class="col-lg-8 ">
                <form action="{{ route('admin.promo-codes.index') }}" method="GET" role="search" class="w-100">
                    <div class="input-group">
                        <input type="text" name="term" id="term" value="{{ $term ?? '' }}" class="form-control bg-light border-0 small" placeholder="Buscar código" aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                    {{-- <input type="text" class="search-promo-code mb-4 float-right" placeholder="Buscar código" name="term" id="term" value="{{ $term ?? '' }}">
                    <button class="btn btn-info btn-lg mb-4 btn-search-code" type="submit" title="Buscar">
                          <span class="fas fa-search"></span>
                    </button> --}}
                </form>
            </div>
        </div>

        <div class="table-responsive">
            @if ($active_plans->hasPages())
            {{ $active_plans->links() }}
            @endif
            <table class="table table-hover ">
                <thead>
                    <tr>
                        <th class="text-center">F. CREACIÓN</th>
                        <th class="text-center">ID</th>
                        <th class="text-center">CÓDIGO</th>
                        <th>PLAN</th>
                        <th>ENLACES</th>
                        <th class="text-center">MESES</th>
                        <th>COSTOS</th>
                        <th class="text-center">ESTADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($active_plans as $plan)
                    <tr>
                        <td>

                            <i class="bi bi-calendar"></i> @formattedDate($plan->created_at)<br>
                            <i class="bi bi-clock"> @formattedTime($plan->created_at)</i>
                        </td>
                        <td class="align-middle text-center">{{ $plan->id }}</td>
                        <th class="align-middle text-center">{{ $plan->promo_code }}</th>
                        <td class="align-middle ">{{ $plan->name }}</td>
                        <td class="align-middle ">
                            @if ($plan->promo_code!='')
                                <a class="btn btn-sm btn-primary" href="{{ route('promo.show', $plan->promo_code) }}" target="_blank"><i class="bi bi-link"></i> ENLACE</a>
                                <a class="btn btn-sm btn-primary" href="{{ route('subscriptions.checkout', $plan) }}" target="_blank"><i class="bi bi-link"></i> ENLACE PAGO</a>
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $plan->months }}</td>
                        <td class="align-middle text-center">
                            S/ @formattedPrice($plan->monthly_price)
                        </td>
                        <td class="align-middle text-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input chkStatus" data-id="{{$plan->id}}" id="chkStatus_{{$plan->id}}" type="checkbox" {{ ($plan->active) ? 'CHECKED' : '' }}>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($active_plans->hasPages())
            {{ $active_plans->links() }}
            @endif

        </div>

    </div>
</div>
{{-- New plan with promo code modal -----------------------------------------------------}}
<div class="modal fade" id="modal-new" tabindex="-1" aria-labelledby="modal-new" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
        <form method="POST" action="{{ route('admin.promo-codes.store') }}">
          @csrf
          <div class="modal-header border-0">
            <h5 class="modal-title" id="modal-new-label">Crear un código promocional</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="input-promo-code" class="form-label">Código</label>
              <input type="text" class="form-control" id="input-promo-code" name="promo_code" required>
              <div id="emailHelp" class="form-text">Sin espacios. Sólo números, letras y guiones.</div>
            </div>
            <div class="mb-3">
              <label for="input-plan-name" class="form-label">Nombre del plan</label>
              <input type="text" class="form-control" id="input-plan-name" name="plan_name" required>
              <div id="emailHelp" class="form-text">Ejemplos: "Acceso mensual", "Acceso bimestral", "Acceso anual"</div>
            </div>
            <div class="mb-3">
              <label for="input-months" class="form-label">Meses</label>
              <input type="number" class="form-control" id="input-months" name="months" required>
            </div>
            <div class="mb-3">
              <label for="input-monthly-price" class="form-label">Precio mensual</label>
              <div class="input-group mb-3">
                <span class="input-group-text">S/</span>
                <input type="number" class="form-control" id="input-monthly-price" name="monthly_price" required>
              </div>
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
@section('inline_scripts')
<script>
    $(document).ready(function() {

        $('.chkStatus').change(function() {
            var status = 0;
            if ($(this).prop('checked')) {
                status = 1;
            }
            var id = $(this).data("id");
            $.ajax({
                type: "PUT",
                url: "{{url(route('admin.promo-codes.update'))}}",
                dataType:'json',
                data: {
                    plan: id,
                    active: status
                },
                success: function(data) {
                    console.log(data)
                },
                error: function(xhr, ajaxOptions, thrownError) {

                }

            });


        })
    })
</script>
@endsection
