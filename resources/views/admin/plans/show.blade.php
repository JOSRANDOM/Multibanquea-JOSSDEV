@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Planes Detalle: {{ $plan->name }}</h1>
    <a class="btn btn-danger btn-sm float-end" href="{{ route('admin.plans.index') }}" title="Volver"><i class="bi bi-arrow-return-left"></i> Volver</a>
</div>
<div class="row">
    <div class="col-12 col-xl-4">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-md icon-shape-primary rounded mr-4 p-4">
              <span class="fas fa-credit-card"></span>
            </div>
            <div>
              <h2 class="mb-0">{{ trans_choice('plans.usage-count', $plan->subscriptions->count() ) }}</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12">
      <div class="card card-body mb-4">
        <h2 class="h4 mb-4">{{ __('plans.information') }}</h2>

        <div class="row">
          <div class="col-12 col-lg-6 mb-4">
            <h3 class="h5 mb-0">{{ __('plans.form.name.label') }}</h3>
            <div>{{ $plan->name }}</div>
          </div>

          <div class="col-12 col-lg-6 mb-4">
            <h3 class="h5 mb-0">{{ __('plans.form.title.label') }}</h3>
            <div>{{ $plan->name }}</div>
          </div>

          <div class="col-12 col-lg-6 mb-4 mb-lg-0">
            <h3 class="h5 mb-0">{{ __('plans.form.months.label') }}</h3>
            <div>{{ $plan->months }}</div>
          </div>

          <div class="col-12 col-lg-6">
            <h3 class="h5 mb-0">{{ __('plans.form.monthly-price.label') }}</h3>
            <div>S/ @formattedPrice($plan->monthly_price)</div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-xl-12">
      <div class="card card-body bg-white mb-4">
        <h2 class="h4 mb-4">{{ __('plans.active-status') }}</h2>

        @if ($plan->active)
        <div class="mb-1"><span class="fas fa-toggle-on mr-2 text-success"></span>{{ __('plans.active-status.active') }}</div>
        <div class="mb-4">
          @if(!$plan->protected)
          <button type="button" data-toggle="modal" data-target="#modal-plan-deactivate" class="btn btn-outline-danger">{{__('generic.deactivate')}}</button>
          @endif
        </div>
        @else
        <div class="mb-1"><span class="fas fa-toggle-off mr-2"></span>{{ __('plans.active-status.inactive') }}</div>
        <div class="mb-4">
          @if(!$plan->protected)
          <button type="button" data-toggle="modal" data-target="#modal-plan-activate" class="btn btn-outline-danger">{{__('generic.activate')}}</button>
          @endif
        </div>
        @endif

        @if ($plan->public)
        <div class="mb-1"><span class="fas fa-eye mr-2 text-success"></span>{{ __('plans.public-status.public') }}</div>
        <div><input class="form-control" value="{{ route('subscriptions.checkout', $plan->name) }}" disabled /></div>
        @else
        <div><span class="fas fa-eye-slash text-warning mr-2"></span>{{ __('plans.public-status.private') }}</div>
        @endif

      </div>
    </div>
</div>
<div class="modal" id="modal-plan-deactivate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('plans.deactivate')}}</h5>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            {{__('El plan quedará desactivado y no podrá ser usado.')}}
          </div>
          <div>
            {{__('Esto no afecta a usuarios que lo están usando actualmente.')}}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('generic.cancel')}}</button>
          <form method="POST" action="{{ route('admin.plans.toggleActive', $plan) }}">
            {{ csrf_field() }}
            <button class="btn btn-outline-danger">
              {{__('plans.deactivate')}}
            </button>
          </form>
        </div>
      </div>
    </div>
</div>
<div class="modal" id="modal-plan-activate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{__('plans.activate')}}</h5>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            {{__('El plan quedará activado y podrá ser usado.')}}
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('generic.cancel')}}</button>
          <form method="POST" action="{{ route('admin.plans.toggleActive', $plan) }}">
            {{ csrf_field() }}
            <button class="btn btn-outline-danger">
              {{__('plans.activate')}}
            </button>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
