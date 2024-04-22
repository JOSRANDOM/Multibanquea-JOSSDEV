@extends('layouts.app')
@section('head.title', 'Comprar acceso - ' . config('app.name'))

@section('main_id', 'no-vue')

@section('content')
<x-facebook-customer-chat />
<x-title label="Comprar acceso" previous-url="{{ route('subscriptions.index') }}"
  description="Obtén acceso total a la plataforma" />

<main>
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card mb-4">
        <div class="card-body">
          <h2 class="h3 mb-0">Detalles de la compra</h2>
        </div>
        <ul class="list-group list-group-flush border-0">
          <li class="list-group-item p-3 bg-light border-top d-flex gap-3 align-items-center">
            <span class="fa-stack fa-2x">
              <i class="fas fa-square fa-stack-2x text-warning opacity-2"></i>
              <i class="fal fa-graduation-cap fa-stack-1x fa-inverse text-primary"></i>
            </span>
            <div>
              <div class="mb-1"><b>{{ $plan->name }} ({{ trans_choice('generic.month', $plan->months) }})</b></div>
              <div class="mb-1">{{ Auth::user()->email }}</div>
              <div>@formattedDate($subscription_starts_at) - @formattedDate($subscription_ends_at)</div>
            </div>
          </li>

          @if($plan->monthly_price < config('variant.regular_monthly_price')) <li
            class="list-group-item p-3 text-muted">
            <div class="row">
              <div class="col-6">
                <b>Precio regular</b>
              </div>
              <div class="col-6 text-end text-lg-start">
                S/ @formattedPrice((config('variant.regular_monthly_price') * $plan->months))
              </div>
            </div>
            </li>

            @if($plan->promo_code)
            <li class="list-group-item p-3 text-danger">
              <div class="row">
                <div class="col-6">
                  <b>Cupón</b>
                </div>
                <div class="col-6 text-end text-lg-start">
                  {{ $plan->promo_code }}
                </div>
              </div>
            </li>
            @endif

            <li class="list-group-item p-3 text-muted">
              <div class="row">
                <div class="col-6">
                  <b>Descuento</b>
                </div>
                <div class="col-6 text-end text-lg-start">
                  - S/ @formattedPrice((config('variant.regular_monthly_price') - $plan->monthly_price) * $plan->months)
                </div>
              </div>
            </li>
            @endif

            <li class="list-group-item p-3">
              <div class="row">
                <div class="col-6">
                  <b>Total</b>
                </div>
                <div class="col-6 text-end text-lg-start">
                  S/ @formattedPrice($plan->monthly_price * $plan->months)
                </div>
              </div>
            </li>
            <li class="list-group-item p-3 bg-light text-muted">
              Al continuar con la compra aceptas el <a href="{{ route('legal.terms') }}" class="text-muted"
                target="_blank">aviso legal y las condiciones de uso</a>.
            </li>
            <li class="list-group-item p-3">
              <a class="btn btn-primary btn-lg" href="{{ $mercado_pago_preference_init_point }}">
                Continuar compra
                <i class="fal fa-arrow-right ms-2"></i>
              </a>
              <div class="mt-3 small text-muted">
                <i class="fal fa-shield-check me-1"></i>
                Tu compra será procesada de manera segura por la pasarela de pagos internacional Mercado Pago.
              </div>
            </li>
        </ul>
      </div>
      <div class="alert alert-primary d-flex gap-3 align-items-center mb-4" role="alert">
        <div class="h2 m-0"><i class="fal fa-fw fa-credit-card"></i></div>
        <div>
          <b>Formas de pago:</b> Puedes pagar con tarjetas de débito y crédito, con efectivo en agentes autorizados
          <span class="opacity-3">(Agente Kasnet, BanBif, BBVA Continental, BCP, Full Carga, Interbank, Scotiabank,
            Tambo, Western Union)</span>, o con banca por internet <span class="opacity-3">(BanBif, BCP, BBVA
            Continental, Interbank, Scotiabank)</span>.
        </div>
      </div>

      <div class="card bg-dark text-white mb-4">
        <div class="card-body">
          <h3 class="h5 mb-4">Preguntas frecuentes</h3>
          <h4 class="h6 mt-4">
            Luego de realizar el pago, ¿en cuanto tiempo se activa mi cuenta?
          </h4>
          <p class="opacity-3">
            En {{ config('app.name') }} contamos con tecnología avanzada. Tu cuenta se activa de forma automática en
            pocos segundos tras realizar tu pago.
          </p>
          <h4 class="h6 mt-4">
            ¿El pago es seguro?
          </h4>
          <p class="opacity-3">
            Sí. A diferencia de otras páginas que informalmente sólo dan un número de WhatsApp para "acordar una forma
            de pago" (altamente inseguro), {{ config('app.name') }} ha integrado "Mercado Pago", la pasarela de pagos de
            Mercado Libre, para brindarte una experencia de pago simple y, sobre todo, con estándares de seguridad
            internacionales.
          </p>
          <h4 class="h6 mt-4">
            ¿La suscripción se renueva automáticamente?
          </h4>
          <p class="opacity-3">
            No. Para ofrecerte mayor flexibilidad, decidimos que las suscripciones no se renueven de forma automática.
            Pero siempre puedes alargar tu suscripción en la sección "Suscripción".
          </p>
          <h4 class="h6 mt-4">
            ¿Ofrecen descuentos para grupos?
          </h4>
          <p class="opacity-3">
            Sí. Nos puedes escribir a {{ env('MAIL_ADDRESS_CONTACT') }} con tu información para realizar un
            paquete a tu medida.
          </p>
          <h4 class="h6 mt-4">
            ¿Cuentan con alguna forma de pago adicional?
          </h4>
          <p class="opacity-3 mb-0">
            Si. Si así lo prefieres, nos puedes escribir a {{ env('MAIL_ADDRESS_CONTACT') }} y podemos brindarte un
            número de cuenta bancaria o Yape.
          </p>
        </div>
      </div>

    </div>

    <div class="col-12 col-lg-4">
      <div class="card text-white mb-4" style="background: radial-gradient(circle, rgb(2, 85, 91), rgb(1, 25, 27));">
        <div class="card-body">
          <h3 class="mb-3 text-warning">Obtén acceso total</h3>
          <div class="mb-3">Accede a todas las funcionalidades de {{ config('app.name') }} para prepararte bien para tu
            examen.</div>
          <ul class="fa-ul mb-0">
            <li class="mb-2">
              <span class="fa-li text-black"><i class="fas fa-check-circle"></i></span>
              <span>Exámenes ilimitados</span>
            </li>
            <li class="mb-2">
              <span class="fa-li text-black"><i class="fas fa-check-circle"></i></span>
              <span>Cientos de preguntas</span>
            </li>
            <li class="mb-2">
              <span class="fa-li text-black"><i class="fas fa-check-circle"></i></span>
              <span>Revisión de resultados</span>
            </li>
            <li class="mb-2">
              <span class="fa-li text-black"><i class="fas fa-check-circle"></i></span>
              <span>Análisis de progreso</span>
            </li>
            <li class="mb-0">
              <span class="fa-li text-black"><i class="fas fa-check-circle"></i></span>
              <span>Ranking de estudiantes</span>
            </li>
          </ul>
        </div>
      </div>

    </div>
  </div>
</main>
@endsection
