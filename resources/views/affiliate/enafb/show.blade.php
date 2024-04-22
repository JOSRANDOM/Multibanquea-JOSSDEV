@extends('layouts.front')
@section('head.title', 'enafb.pe - Prepárate para el Examen Nacional de Farmacia y Bioquímica')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-1 text-warning"><b>La plataforma de bancos de preguntas para el ENAFB</b></div>
        <div class="mb-1 text-warning"><b>Recomendada por {{ $affiliate->name }}</b></div>
        <h1 class="mb-4">Prepárate para el Examen Nacional de Farmacia y Bioquímica</h1>
        <div class="mb-4"><b>ENAFB.pe</b> es la plataforma digital especializada en el repaso de preguntas para el ENAFB.
        </div>
        <ul class="fa-ul mb-4">
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true"
                class="fal fa-check-circle opacity-3"></i></span>Practica con exámenes ilimitados</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true"
                class="fal fa-check-circle opacity-3"></i></span>Con más de 1000 preguntas para el ENAFB</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true"
                class="fal fa-check-circle opacity-3"></i></span>Analiza tu rendimiento por área de estudio</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true"
                class="fal fa-check-circle opacity-3"></i></span>Escala en el ranking de estudiantes</li>
        </ul>
        <a class="btn btn-lg btn-warning animate__animated animate__tada animate__delay-2s"
          href="#descuento-especial">
          Descuento especial<i class="fal fa-arrow-right ms-2"></i>
        </a>
      </div>
      <div class="col-5 m-auto col-md-4 col-lg-3 m-lg-0">
        <img class="img-fluid" src="{{ asset('/img/welcome/enafb/hero-phone.png') }}"
          alt="Vista de respuesta de un examen en ENAFB.pe" style="transform: rotate(5deg);">
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
