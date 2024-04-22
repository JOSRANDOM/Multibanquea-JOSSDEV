@extends('layouts.front')
@section('head.title', 'ENARM.pe - Prepárate para el Examen Nacional de Residencia Medicina')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-1 text-warning"><b>La plataforma de bancos de preguntas para el ENARM</b></div>
        <h1 class="mb-4">Banquea sin límites para el Examen de Residencia Médica</h1>
        <div class="alert alert-warning mb-4 animate__animated animate__tada" role="alert">
          <p><b>¡Promoción especial!</b></p>
          <p class="mb-0">Obtén {{ trans_choice('generic.month', $plan->months) }} de acceso a {{ config('app.name') }} por <b>S/ @formattedPrice($plan->monthly_price * $plan->months)</b> <span class="text-decoration-line-through">S/ @formattedPrice(config('variant.regular_monthly_price')* $plan->months)</span></p>
        </div>
        <div class="mb-4">Simulacros ilimitados y más de 5000 preguntas en la plataforma más moderna del Perú.</div>
        <div class="mb-4">Evalúa tu progreso por ramas de estudio, genera exámenes para reforzar los temas que necesites, y mira tus resultados al instante.</div>
        <a class="btn btn-lg btn-warning animate__animated animate__tada animate__delay-2s" href="{{ route('subscriptions.checkout', $plan) }}">
          Aprovechar promoción<i class="fal fa-arrow-right ms-2"></i>
        </a>
        <div class="mt-3 opacity-4 mb-5 mb-lg-0">Aplicaremos el cupón de descuento <span class="font-monospace">{{ $plan->promo_code }}</span> automáticamente</div>
      </div>
      <div class="col-5 m-auto col-md-4 col-lg-3 m-lg-0">
        <img class="img-fluid" src="{{ asset('/img/welcome/enarm/hero-phone.png') }}" alt="Vista de respuesta de un examen en ENARM.pe" style="transform: rotate(5deg);">
      </div>
    </div>
  </div>
</section>

<x-landing-pages.sections.introduction />
<x-landing-pages.sections.step-by-step />
<x-landing-pages.sections.testimonial />

{{-- Section: Pricing --------------------------------------------------------}}
<section class="section py-7">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 text-md-center mb-5">
        <h2 class="display-5 fw-bold mb-2">¡No dejes pasar esta promoción!</h2>
        <p class="lead mb-4">Obtén acceso a todas las funcionalidades de {{ config('app.name') }} a un precio especial.</p>
        <a class="btn btn-lg btn-danger animate__animated animate__tada animate__delay-2s" href="{{ route('subscriptions.checkout', $plan) }}">
          Aprovechar promoción<i class="fal fa-arrow-right ms-2"></i>
        </a>
        <div class="text-muted mt-3">Aplicaremos el cupón de descuento <span class="font-monospace">{{ $plan->promo_code }}</span> automáticamente</div>
      </div>
    </div>
  </div>
</section>

<x-landing-pages.sections.about-us />
@endsection
