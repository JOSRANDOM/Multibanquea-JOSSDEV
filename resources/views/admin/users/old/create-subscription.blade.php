@extends('layouts.app')

@section('content')
<x-title label="{{ __('subscriptions.new') }}" previous-url="{{ route('admin.users.show', $user) }}" />

<main>
  @if ($errors->any())
  <div class="alert alert-danger" role="alert">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <div class="row">
    <div class="col-12 col-xl-8">
      <div class="card mb-4">
        <div class="card-body">
          <form method="POST" action="{{ route('admin.users.storeSubscription', $user) }}">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start" class="h5">{{ __('subscriptions.form.start.label') }}</label>
                  <input class="form-control" name="starts_at" id="input-start" aria-describedby="input-start-help" value="{{ now() }}" required />
                  <small id="input-start-help" class="form-text text-muted">{{ __('subscriptions.form.start.help') }}</small>
                </div>
              </div>
            </div>

            <div class="mb-4">{{ __('La hora y fecha del fin de la suscripción se calculará automáticamente añadiendo el número de meses del plan elegido.') }} </div>

            <hr>

            <div class="h5">{{ trans_choice('plans.plan', 1) }}</div>

            <div class="table-responsive">
              <table class="table table-centered table-nowrap table-striped mb-0 rounded">
                <thead class="thead-light">
                  <tr>
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
                    <td class="border-0 font-weight-bold">{{ $plan->name }}</td>
                    <td class="border-0">{{ $plan->name }}</td>
                    <td class="border-0">{{ $plan->months }}</td>
                    <td class="border-0">{{ __('S/') }} @formattedPrice($plan->monthly_price)</td>
                    <td>
                      <button name="plan_id" value="{{ $plan->id }}" class="btn btn-primary float-right">{{ __('generic.create') }}</button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col-12 col-xl-4">
      <div class="card card-body bg-white mb-4">
        <h2 class="h4 mb-4">{{ trans_choice('users.user', 1) }}</h2>

        <div class="mb-4">
          <h3 class="h5 mb-0">{{ __('users.name') }}</h3>
          <div>{{ $user->name }}</div>
        </div>

        <div>
          <h3 class="h5 mb-0">{{ __('users.email') }}</h3>
          <div>{{ $user->email }}</div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h2 class="h4">{{ __('subscriptions.history') }}</h2>

          <div class="d-block">
            @forelse ($user->subscriptions->sortByDesc('starts_at') as $subscription)
            <div class="d-flex align-items-center pt-3 mr-5">
              <div class="icon icon-shape icon-sm icon-shape-warning rounded mr-3 p-3">
                <span class="fas fa-unlock"></span>
              </div>
              <div class="d-block">
                <label class="mb-0">@formattedDate($subscription->starts_at) - @formattedDate($subscription->ends_at)</label>
                <h4 class="mb-0">{{ __('plans.premium') }}</h4>
              </div>
            </div>
            @empty
            <div class="text-muted">{{ __('subscriptions.none')}}</div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
