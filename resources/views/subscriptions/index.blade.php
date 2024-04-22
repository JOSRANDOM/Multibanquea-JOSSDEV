@extends('layouts.app')
@section('head.title', 'Suscripción - ' . config('app.name'))

@section('content')
<x-facebook-customer-chat />
<x-title label="Suscripción" previous-url="{{ route('home') }}" description="Obtén acceso total a la plataforma" />

<main>
  @if (Auth::user()->isSubscribed())
  <x-card-active-subscription :user="Auth::user()" :show-cta="false" />
  @else
  <x-card-upgrade :show-cta="false" />
  @endif

  <div class="my-6">

    @if(Auth::user()->isSubscribed())
    <h2 class="display-5 fw-bold text-lg-center text-white">Alarga tu acceso a {{ config('app.name') }}</h2>
    <p class="lead mb-4 text-lg-center text-white opacity-3">Continúa teniendo acceso total a la plataforma después del @formattedDate(Auth::user()->active_subscription->ends_at).</p>
    @else
    <h2 class="display-5 fw-bold text-lg-center text-white">Obtén acceso a {{ config('app.name') }}</h2>
    <p class="lead mb-4 text-lg-center text-white opacity-3">Compra acceso a todas las funcionalidades de la plataforma.</p>
    @endif

    <x-pricing breakpoint="lg" dark-layout />
  </div>
  <x-card-user-subscriptions :user="Auth::user()" />
</main>
@endsection
