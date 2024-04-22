@extends('layouts.front')
@section('head.title', 'ENAO.pe - Prepárate para el Examen Nacional de Odontología')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-1 text-warning"><b>La plataforma de bancos de preguntas para el ENAO y el Residentado de Odontología</b></div>
        <h1 class="mb-4">Prepárate para el Examen Nacional de Odontología y el Residentado de Odontología</h1>
        <div class="alert alert-warning mb-4 animate__animated animate__tada" role="alert">
          <p><b>¡Promoción especial!</b></p>
          <p class="mb-0">Obtén {{ trans_choice('generic.month', $plan->months) }} de acceso a {{ config('app.name') }} por <b>S/ @formattedPrice($plan->monthly_price * $plan->months)</b> <span class="text-decoration-line-through">S/ @formattedPrice(config('variant.regular_monthly_price')* $plan->months)</span></p>
        </div>
        <div class="mb-4"><b>ENAO.pe</b> es la plataforma digital especializada en el repaso de preguntas para el ENAO y el Residentado de Odontología.</div>
        <ul class="fa-ul mb-4">
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Practica con exámenes ilimitados</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Con más de 1500 preguntas para el ENAO y el Residentado de Odontología</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Analiza tu rendimiento por área de estudio</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Escala en el ranking de estudiantes</li>
        </ul>
        <a class="btn btn-lg btn-warning animate__animated animate__tada animate__delay-2s" href="{{ route('subscriptions.checkout', $plan) }}">
          Aprovechar promoción<i class="fal fa-arrow-right ms-2"></i>
        </a>
        <div class="mt-3 opacity-4 mb-5 mb-lg-0">Aplicaremos el cupón de descuento <span class="font-monospace">{{ $plan->promo_code }}</span> automáticamente</div>
      </div>
      <div class="col-5 m-auto col-md-4 col-lg-3 m-lg-0">
        <img class="img-fluid" src="{{ asset('/img/welcome/enao/hero-phone.png') }}" alt="Vista de respuesta de un examen en ENAO.pe" style="transform: rotate(5deg);">
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
