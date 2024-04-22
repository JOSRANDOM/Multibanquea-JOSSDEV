@extends('layouts.front')
@section('head.title', 'ENAM.pe - Prepárate para el Examen Nacional de Medicina')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-1 text-warning"><b>La plataforma de bancos de preguntas para el ENAM</b></div>
        <div class="mb-1 text-warning"><b>Recomendada por {{ $affiliate->name }}</b></div>
        <h1 class="mb-4">Prepárate al 100% para el Examen Nacional de Medicina</h1>
        <div class="mb-4">Simulacros ilimitados y más de 5000 preguntas en la plataforma más moderna del Perú.</div>
        <div class="mb-4">Evalúa tu progreso por ramas de estudio, genera exámenes para reforzar los temas que
          necesites, y mira tus resultados al instante.</div>
        <a class="btn btn-lg btn-warning animate__animated animate__tada animate__delay-2s"
          href="#descuento-especial">
          Descuento especial<i class="fal fa-arrow-right ms-2"></i>
        </a>
      </div>
      <div class="col-5 m-auto col-md-4 col-lg-3 m-lg-0">
        <img class="img-fluid" src="{{ asset('/img/welcome/enam/hero-phone.png') }}"
          alt="Vista de respuesta de un examen en ENAM.pe" style="transform: rotate(5deg);">
      </div>
    </div>
  </div>
</section>

<x-landing-pages.sections.introduction />
<x-landing-pages.sections.step-by-step />
<x-landing-pages.sections.testimonial />

<section class="section py-7" id="descuento-especial">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-8 text-md-center mb-5">
        <h2 class="display-5 fw-bold mb-2">¡Descuento especial!</h2>
        <p class="lead mb-4">Obtén acceso a todas las funcionalidades de {{ config('app.name') }} a un precio especial.
      </div>
    </div>
    <x-pricing-plans :plan1="$affiliate->plans->where('months', 3)->first()"
      :plan2="$affiliate->plans->where('months', 6)->first()" />
  </div>
</section>

<x-landing-pages.sections.about-us />
@endsection
