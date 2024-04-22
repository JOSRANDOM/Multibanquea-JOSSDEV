@extends('layouts.madmin')
@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Referencias de compra</h1>
</div>
@if (session('status'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <span class="alert-inner--text">{{ session('status') }}</span>
  <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('generic.close') }}">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
<div class="row">
    <div class="col-12 col-xl-6">
      <div class="card mb-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="icon icon-shape icon-md icon-shape-primary rounded mr-4 p-4">
              <span class="fas fa-cash-register"></span>
            </div>
            <div>
              <h2 class="mb-0">{{ trans_choice('checkout-references.count', $checkout_references->total()) }}</h2>
              <div>
                <div class="d-md-inline"><i class="fas fa-clock mr-2"></i>{{ __('generic.latest') }}: @formattedDate($latest_checkout_reference)</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-body">

          @if ($checkout_references->hasPages())
          <div class="mb-3">
            {{ $checkout_references->links() }}
          </div>
          @endif

          <div class="table-responsive">
            <table class="table table-centered table-nowrap table-striped mb-0 rounded">
              <thead class="thead-light">
                <tr>
                  <th class="border-0">{{ __('#') }}</th>
                  <th class="border-0">{{ __('checkout-references.payment-status') }}</th>
                  <th class="border-0">{{ trans_choice('users.user', 1) }}</th>
                  <th class="border-0">{{ trans_choice('plans.plan', 1) }}</th>
                  <th class="border-0">{{ __('checkout-references.total-price') }}</th>
                  <th class="border-0">{{ __('generic.created-at') }}</th>
                  <th class="border-0">{{ __('generic.updated-at') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($checkout_references as $checkout_reference)
                <tr>
                  <td class="border-0">{{ $checkout_reference->id }}</td>
                  @if ($checkout_reference->isPaid())
                  <td class="border-0 font-weight-bold text-success">
                    <span class="fas fa-receipt mr-2"></span>{{ __('checkout-references.payment-status.paid') }}
                  </td>
                  @else
                  <td class="border-0 text-muted">
                    <div><b><span class="fas fa-clock mr-2"></span>{{ __('checkout-references.payment-status.pending') }}</b></div>
                    <div>{{ __('checkout-references.amount-pending') }}: {{ __('S/') }} @formattedPrice(($checkout_reference->total_price - $checkout_reference->amount_paid))</div>
                  </td>
                  @endif
                  <td class="border-0">
                    <div><b><a href="{{ route('admin.users.show', $checkout_reference->user) }}">{{ $checkout_reference->user->name }}</a></b></div>
                    <div>{{ $checkout_reference->user->email }}</div>
                  </td>
                  <td class="border-0">
                    <div><b><a href="{{ route('admin.plans.show', $checkout_reference->plan) }}">{{ $checkout_reference->plan->name }}</a></b></div>
                    <div>{{ $checkout_reference->plan->name }}</div>
                  </td>
                  <td class="border-0">{{ __('S/') }} @formattedPrice($checkout_reference->total_price)</td>
                  <td class="border-0">{{ $checkout_reference->created_at }}</td>
                  <td class="border-0">{{ $checkout_reference->updated_at }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          @if ($checkout_references->hasPages())
          <div class="mt-3">
            {{ $checkout_references->links() }}
          </div>
          @endif

        </div>
      </div>
    </div>
</div>

@endsection
