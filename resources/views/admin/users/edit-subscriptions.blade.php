@extends('layouts.app')

@section('content')
<x-title label="{{ trans_choice('subscriptions.subscription', 1) }} #{{ $subscription->id }}" previous-url="{{ route('admin.users.show', $user) }}" />

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
      <div class="card card-body mb-4">
        <h2 class="h4 mb-4">{{ __('subscriptions.current-duration') }}</h2>

        <div class="row">
          <div class="col-12 col-lg-6 mb-4">
            <h3 class="h5 mb-0">{{ __('subscriptions.form.start.label') }}</h3>
            <div><input class="form-control" value="{{ $subscription->starts_at }}" disabled /></div>
          </div>

          <div class="col-12 col-lg-6 mb-4">
            <h3 class="h5 mb-0">{{ __('subscriptions.form.end.label') }}</h3>
            <div><input class="form-control" value="{{ $subscription->ends_at }}" disabled /></div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <h3 class="h5 mb-0">{{ __('subscriptions.active-status') }}</h3>
            <div>
              @if ($subscription->isActive())
              <span class="fas fa-toggle-on mr-2 text-success"></span>{{ __('subscriptions.active-status.active') }}
              @else
              <span class="fas fa-toggle-off mr-2 text-muted"></span>{{ __('subscriptions.active-status.inactive') }}
              @endif
            </div>
          </div>
        </div>
      </div>

      <div class="card mb-4">
        <div class="card-body">
          <h2 class="h4 mb-4">{{ __('subscriptions.new-duration') }}</h2>

          <form method="POST" action="{{ route('admin.users.updateSubscription', [$user, $subscription]) }}">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-12 col-lg-6">
                <div class="form-group">
                  <label for="input-start">{{ __('subscriptions.form.start.label') }}</label>
                  <input class="form-control" name="starts_at" id="input-start" aria-describedby="input-start-help" value="{{ $subscription->starts_at }}" required />
                  <small id="input-start-help" class="form-text text-muted">{{ __('subscriptions.form.start.help') }}</small>
                </div>

                <div class="mb-4">{{ __('La hora y fecha del fin de la suscripción se calculará automáticamente añadiendo el número de meses del plan:') }} {{ $subscription->plan->months }}</div>

                <button class="btn btn-primary">{{ __('generic.update') }}</button>
              </div>
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

      <div class="card card-body bg-white mb-4">
        <h2 class="h4 mb-4">{{ trans_choice('plans.plan', 1) }}</h2>

        <div class="mb-4">
          <h3 class="h5 mb-0">{{ __('plans.title') }}</h3>
          <div>{{ $subscription->plan->name }}</div>
        </div>

        <div class="mb-4">
          <h3 class="h5 mb-0">{{ __('plans.name') }}</h3>
          <div>{{ $subscription->plan->name }}</div>
        </div>

        <div>
          <h3 class="h5 mb-0">{{ __('plans.months') }}</h3>
          <div>{{ $subscription->plan->months }}</div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection
