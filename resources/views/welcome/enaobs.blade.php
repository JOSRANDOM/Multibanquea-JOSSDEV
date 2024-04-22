@extends('layouts.front')
@section('head.title', 'ENAOBS.pe - Prepárate para el Examen Nacional de Obstetricia')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-1 text-warning"><b>La plataforma de bancos de preguntas para el ENAOBS</b></div>
        <h1 class="mb-4">Banquea sin límites para el Examen Nacional de Obstetricia</h1>
        <div class="mb-4">Simulacros ilimitados y más de 1000 preguntas en la plataforma más moderna del Perú.</div>
        <div class="mb-4">Evalúa tu progreso por ramas de estudio, genera exámenes para reforzar los temas que necesites, y mira tus resultados al instante.</div>
        <a class="btn btn-lg btn-warning animate__animated animate__tada animate__delay-2s mb-5 mb-lg-0" href="{{ route('login') }}">
          Ingresar<i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
      <div class="col-5 m-auto col-md-4 col-lg-3 m-lg-0">
        <img class="img-fluid" src="{{ asset('/img/welcome/enarm/hero-phone.png') }}" alt="Vista de respuesta de un examen en ENAOBS.PE" style="transform: rotate(5deg);">
      </div>
    </div>
  </div>
</section>

<x-landing-pages.sections.introduction />
<x-landing-pages.sections.step-by-step />
<x-landing-pages.sections.testimonial />
<x-landing-pages.sections.pricing-plans />
<x-landing-pages.sections.about-us />
@endsection
