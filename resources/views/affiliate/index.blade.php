@extends('layouts.front')
@section('head.title', 'Programa de afiliados de ' . config('app.name') . ' - Únete y gana')
@section('head.description', 'Programa de afiliados en Perú. Gana dinero por referencias con el programa de marketing de
afiliados de ' .config('app.name') .'. ¡Regístrate ahora!')
@section('head.og-image', '/img/affiliates/og-afiliados.jpeg')

@section('content')
<x-facebook-customer-chat />

{{-- Section: Header ---------------------------------------------------------}}
<section class="section-header py-5 text-white shadow-lg welcome-hero">
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-12 col-lg-6">
        <div class="mb-4 text-warning"><b>El programa de afiliados de {{ config('app.name') }}</b></div>
        <h1 class="mb-4">Obtén 12% de comisión por cada referido</h1>
        <div class="mb-4">
          <p>
            Si eres un creador de contenido o influencer y estás buscando generar un ingreso extra, inscríbete en
            nuestro programa de afiliados.
          </p>
          <p>
            Por cada usuario refererido que compre una suscripción, te llevarás el 12% del monto del plan pagado.
          </p>
        </div>
        <a class="btn btn-lg btn-warning" href="https://forms.gle/EvcLDwL4MPVbGgo7A" target="_blank"
          rel="noopener">
          Regístrate ahora<i class="fal fa-arrow-right ms-2"></i>
        </a>
      </div>
      <div class="mt-4 m-auto m-lg-0 col-8 col-md-6 col-lg-5">
        <img class="img-fluid" src="{{ asset('/img/affiliates/afiliada.png') }}" alt="Afiliada con un plan de ingresos">
      </div>
    </div>
  </div>
</section>

<section class="section py-7 bg-light">
  <div class="container">
    <h2 class="display-5 fw-bold mb-6 text-center">Recibe tus pagos mensualmente</h2>
    <div class="row">
      <div class="mb-6 mb-lg-0 col-8 offset-2 col-md-6 offset-md-3 col-lg-5 offset-lg-0 col-xl-4 offset-xl-1">
        <img class="img-fluid" src="{{ asset('/img/affiliates/pagos-mensuales.png') }}"
          alt="Afiliada con pagos recurrentes">
      </div>
      <div class="col col-md-10 offset-md-1 col-lg-6 offset-lg-1 col-xl-5">
        <div class="mb-5">
          <h3>Regístrate</h3>
          <p>
            Una vez te registres en nuestro programa de afiliados, recibirás unos enlaces personalizados con tu nombre o
            marca, desde donde tus referidos podrán obtener suscripciones a precios especiales.
          </p>
        </div>
        <div class="mb-5">
          <h3>Recomiéndanos</h3>
          <p>
            Utiliza tus redes sociales y otros medios de difusión para compartir con tu público tus enlaces
            personalizados.
          </p>
        </div>
        <div class="mb-5">
          <h3>Sé recompensado</h3>
          <p>
            Si tus referidos compran una suscripción, obtendrás 12% del monto del plan pagado.</p>
          <p>
            Desde tu cuenta de {{ config('app.name') }} podrás ver el número de clics en tus enlaces y compras de tus
            referidos, y recibirás tus pagos mensualmente.
          </p>
        </div>
        <a class="btn btn-lg btn-warning" href="https://forms.gle/EvcLDwL4MPVbGgo7A" target="_blank"
          rel="noopener">
          Regístrate ahora<i class="fal fa-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="section py-7">
  <div class="container">
    <h2 class="display-5 fw-bold mb-6 text-center">Te ayudamos a llegar a más personas</h2>
    <div class="row">
      <div class="mb-6 mb-lg-0 col-8 offset-2 col-md-6 offset-md-3 col-lg-5 offset-lg-0 col-xl-4 offset-xl-1">
        <img class="img-fluid" src="{{ asset('/img/affiliates/exito.png') }}"
          alt="Afiliados celebrando su éxito levantando un trofeo">
      </div>
      <div class="col col-md-10 offset-md-1 col-lg-6 offset-lg-1 col-xl-5">
        <div class="mb-5">
          <p>
            Queremos que te beneficies de esta oportunidad, y por esto te brindamos herramientas para que puedas sacar
            el máximo provecho al programa de afiliados.
          </p>
        </div>
        <div class="mb-5">
          <h3>Tablero de control</h3>
          <p>
            Podrás monitorizar la eficacia de tus campañas y el impacto en tus seguidores. Tendrás acceso a métricas en
            tiempo real desde tu cuenta, como el número de clics en tus enlaces y compras de tus referidos.
          </p>
        </div>
        <div class="mb-5">
          <h3>Plantillas y materiales de difusión</h3>
          <p>
            Pondremos a tu disposición material gráfico de alta calidad y diseño, optimizado para tus redes sociales y
            casos de uso, con el cual podrás promocionar {{ config('app.name') }} de forma inmediata y sencilla.
          </p>
        </div>
        <div class="mb-5">
          <h3>Seguimiento continuo</h3>
          <p>
            Estaremos en constante comunicación contigo.
          </p>
          <p>
            Al ser parte de nuestro programa de afiliados, podrás comunicarte con nosotros cada vez que tengas una duda
            o sugerencia, y estaremos ahí para atenderte inmediatamente.
          </p>
        </div>
        <a class="btn btn-lg btn-warning" href="https://forms.gle/EvcLDwL4MPVbGgo7A" target="_blank"
          rel="noopener">
          Regístrate ahora<i class="fal fa-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="section py-7 bg-primary text-white">
  <div class="container text-center">
    <h2 class="mb-4">¡Únete al programa de afiliados de {{ config('app.name') }}!</h2>
    <a class="btn btn-lg btn-warning" href="https://forms.gle/EvcLDwL4MPVbGgo7A" target="_blank" rel="noopener">
      Regístrate ahora<i class="fal fa-arrow-right ms-2"></i>
    </a>
  </div>
</section>
@endsection
