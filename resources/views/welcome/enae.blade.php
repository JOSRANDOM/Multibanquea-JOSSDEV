@extends('layouts.front')
@section('head.title', 'ENAE.pe - Prepárate para el Examen Nacional de Enfermería y el Residentado de Enfermería')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-1 text-warning"><b>La plataforma de bancos de preguntas para el ENAE y el Residentado de Enfermería</b></div>
        <h1 class="mb-4">Prepárate para el Examen Nacional de Enfermería y el Examen de Residentado de Enfermería</h1>
        <div class="mb-4"><b>ENAE.pe</b> es la plataforma digital especializada en el repaso de preguntas validadas y comentadas para el ENAE.</div>
        <ul class="fa-ul mb-4">
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Preguntas validadas y comentadas por los mejores especialistas</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Practica con exámenes ilimitados</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Con más de 1200 preguntas para el ENAE y el Residentado de Enfermería</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Analiza tu rendimiento por área de estudio</li>
          <li class="mt-1"><span class="fa-li"><i aria-hidden="true" class="fal fa-check-circle opacity-3"></i></span>Escala en el ranking de estudiantes</li>
        </ul>
        <a class="btn btn-lg btn-warning animate__animated animate__tada animate__delay-2s mb-5 mb-lg-0" href="{{ route('login') }}">
          Empezar<i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
      <div class="col-5 m-auto col-md-4 col-lg-3 m-lg-0">
        <img class="img-fluid" src="{{ asset('/img/welcome/enae/hero-phone.png') }}" alt="Vista de respuesta de un examen en ENAE.pe" style="transform: rotate(5deg);">
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
