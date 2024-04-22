@extends('layouts.app')

@section('content')
<x-title label="{{ trans_choice('plans.plan', 2) }}" previous-url="{{ route('home') }}" />

<main>
  @if (session('status'))
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <span class="alert-inner--text">{{ session('status') }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

  <div class="row">
    <div class="col-12 col-xl-4">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-md icon-shape-primary rounded mr-4 p-4">
              <span class="fas fa-credit-card"></span>
            </div>
            <div>
              <h2 class="mb-0">{{ trans_choice('plans.count', $plans->total()) }}</h2>
              <div>
                <div class="d-md-inline"><i class="fas fa-toggle-on mr-2"></i>{{ trans_choice('plans.active-plan-count', $active_plans_count) }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mb-4">
    <a href="{{ route('admin.plans.create') }}" class="btn btn-primary"><span class="fas fa-plus mr-2"></span>{{ __('plans.new') }}</a>
  </div>

  <div class="row">
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-body">

          @if ($plans->hasPages())
          <div class="mb-3">
            {{ $plans->links() }}
          </div>
          @endif

          <div class="table-responsive">
            <table class="table table-centered table-nowrap table-striped mb-0 rounded">
              <thead class="thead-light">
                <tr>
                  <th class="border-0">{{ __('#') }}</th>
                  <th class="border-0">{{ __('plans.active-status') }}</th>
                  <th class="border-0">{{ __('plans.usages') }}</th>
                  <th class="border-0">{{ __('plans.name') }}</th>
                  <th class="border-0">{{ __('plans.title') }}</th>
                  <th class="border-0">{{ __('plans.months') }}</th>
                  <th class="border-0">{{ __('plans.monthly-price') }}</th>
                  <th class="border-0"></th>
                </tr>
              </thead>
              <tbody>
                @foreach ($plans as $plan)
                <tr>
                  <td class="border-0">{{ $plan->id }}</td>
                  <td class="border-0">
                    @if ($plan->active)
                    <div class="font-weight-normal text-success mt-1"><span class="fas fa-toggle-on mr-2"></span>{{ __('plans.active-status.active') }}</div>
                    @else
                    <div class="font-weight-normal text-warning mt-1"><span class="fas fa-toggle-off mr-2"></span>{{ __('plans.active-status.inactive') }}</div>
                    @endif
                  </td>
                  <td class="border-0">{{ $plan->subscriptions->count() }}</td>
                  <td class="border-0 font-weight-bold">
                    <div>{{ $plan->name }}</div>
                    @if ($plan->public)
                    <div class="font-weight-normal text-success mt-1">
                      <span class="fas fa-eye mr-2"></span>{{ __('plans.public-status.public') }}
                      @if ($plan->active)
                      <span class="text-gray">(<a class="text-underline" href="{{ route('subscriptions.checkout', $plan->name) }}">{{ __('plans.go-to-public-page') }}</a>)</span>
                      @endif
                    </div>
                    @else
                    <div class="font-weight-normal text-warning mt-1"><span class="fas fa-eye-slash mr-2"></span>{{ __('plans.public-status.private') }}</div>
                    @endif
                  </td>
                  <td class="border-0">{{ $plan->name }}</td>
                  <td class="border-0">{{ $plan->months }}</td>
                  <td class="border-0">{{ __('S/') }} @formattedPrice($plan->monthly_price)</td>
                  <td><a href="{{ route('admin.plans.show', $plan) }}" class="btn btn-primary float-right">{{ __('generic.details') }}</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($plans->hasPages())
          <div class="mt-3">
            {{ $plans->links() }}
          </div>
          @endif

        </div>
      </div>
    </div>
  </div>
</main>
@endsection
