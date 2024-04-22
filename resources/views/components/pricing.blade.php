<section class="section py-7 bg-light">
  <div class="row row-cols-1 row-cols-{{ $breakpoint }}-3 text-center mb-5">
    <div class="col mb-5 mb-{{ $breakpoint }}-0">
      <div class="card h-100">
        <div class="card-header">
          <h3 class="h5 my-2 fw-normal">Prueba</h3>
        </div>
        <div class="card-body">
          <h4 class="card-title h1 mb-3">
            Gratis
          </h4>
          <ul class="list-unstyled mb-0">
            <li>Prueba {{ config('app.name') }} con funcionalidades limitadas</li>
          </ul>
        </div>
        @guest
        <div class="card-footer bg-white border-0 pb-3 pt-0">
          <a href="{{ route('home') }}" class="w-100 btn btn-lg btn-outline-primary">Empezar<i class="bi bi-arrow-right ms-2"></i></a>
        </div>
        @endguest
      </div>
    </div>
    <div class="col mb-5 mb-{{ $breakpoint }}-0">
      <div class="card h-100 border-dark">
        <div class="card-header">
          <h3 class="h5 my-2 fw-normal">{{ $plan_1->name }}</h3>
        </div>
        <div class="card-body">
          <h4 class="card-title h1 mb-3">
            S/ @formattedPrice($plan_1->monthly_price * $plan_1->months)
  
            @if ($plan_1_has_discount)
            <small class="fs-6 align-middle text-decoration-line-through text-muted">
              S/ @formattedPrice(config('variant.regular_monthly_price') * $plan_1->months)
            </small>
            @endif
  
          </h4>
          <ul class="list-unstyled mb-0 lh-sm">
            <li class="mb-2">Exámenes ilimitados</li>
            <li class="mb-2">Cientos de preguntas</li>
            <li class="mb-2">Revisión de resultados</li>
            <li class="mb-2">Análisis de progreso</li>
            <li class="mb-2">Ranking de estudiantes</li>
          </ul>
        </div>
        <div class="card-footer bg-white border-0 pb-3 pt-0">
          <a href="{{ route('subscriptions.checkout', $plan_1) }}" class="w-100 btn btn-lg btn-primary">Comprar<i class="bi bi-arrow-right ms-2"></i></i></a>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100">
        <div class="card-header">
          <h3 class="h5 my-2 fw-normal">{{ $plan_2->name }}</h3>
        </div>
        <div class="card-body">
          <h4 class="card-title h1 mb-3">
            S/ @formattedPrice($plan_2->monthly_price * $plan_2->months)
  
            @if ($plan_2_has_discount)
            <small class="fs-6 align-middle text-decoration-line-through text-muted">
              S/ @formattedPrice(config('variant.regular_monthly_price') * $plan_2->months)
            </small>
            @endif
          </h4>
          <ul class="list-unstyled mb-0 lh-sm">
            <li class="mb-2">Exámenes ilimitados</li>
            <li class="mb-2">Cientos de preguntas</li>
            <li class="mb-2">Revisión de resultados</li>
            <li class="mb-2">Análisis de progreso</li>
            <li class="mb-2">Ranking de estudiantes</li>
          </ul>
        </div>
        <div class="card-footer bg-white border-0 pb-3 pt-0">
          <a href="{{ route('subscriptions.checkout', $plan_2) }}" class="w-100 btn btn-lg btn-primary">Comprar<i class="bi bi-arrow-right ms-2"></i></i></a>
        </div>
      </div>
    </div>
  </div>
  
  <!--<div class="row row-cols-1 row-cols-{{ $breakpoint }}-3 text-center mb-5">
      <div class="col mb-5 mb-{{ $breakpoint }}-0">
          <div class="card h-100">
              <div class="card-header">
                  <h3 class="h5 my-2 fw-normal">Premium + Cursos</h3>
              </div>
              <div class="card-body">
                  <h4 class="card-title h1 mb-3">
                      S/ @formattedPrice($plan_3->monthly_price * $plan_3->months)
  
                      @if ($plan_1_has_discount)
                          <small class="fs-6 align-middle text-decoration-line-through text-muted">
                              S/ @formattedPrice(config('variant.regular_monthly_price') * $plan_3->months)
                          </small>
                      @endif
  
                  </h4>
                  <ul class="list-unstyled mb-0 lh-sm">
                      <li class="mb-2">Exámenes ilimitados</li>
                      <li class="mb-2">Cientos de preguntas</li>
                      <li class="mb-2">Revisión de resultados</li>
                      <li class="mb-2">Análisis de progreso</li>
                      <li class="mb-2">Ranking de estudiantes</li>
                      <li class="mb-2">Cursos en Línea</li>
                  </ul>
              </div>
              <div class="card-footer bg-white border-0 pb-3 pt-0">
                  <a href="{{ route('subscriptions.checkout', $plan_3) }}" class="w-100 btn btn-lg btn-primary">Comprar<i class="fal fa-arrow-right ms-2"></i></a>
              </div>
  
          </div>
      </div>
  </div>-->
  
  <div class="row justify-content-center">
    <div class="col-12 col-lg-6">
      <div class="alert alert-primary d-flex gap-3 align-items-center" role="alert">
        <div class="h2 m-0"><i class="fal fa-fw fa-shield-check"></i></div>
        <div>Las compras son procesadas de manera segura por la pasarela de pagos <b>Mercado Pago</b>.</div>
      </div>
      <div class="alert alert-primary d-flex gap-3 align-items-center" role="alert">
        <div class="h2 m-0"><i class="fal fa-fw fa-credit-card"></i></div>
        <div>Puedes pagar con tarjetas de débito y crédito, así­ como con efectivo en agentes autorizados, o banca por internet.</div>
      </div>
      <div class="mt-5 text-{{ $breakpoint }}-center">
        <h3 class="{{ $darkLayout ? 'text-white' : ''}}">¿Algún problema o duda adicional?</h3>
        <div class="lead mb-3 {{ $darkLayout ? 'text-white opacity-3' : ''}}">Con gusto te ayudamos personalmente.</div>
        <button type="button" class="btn {{ $darkLayout ? 'btn-outline-light' : 'btn-primary'}}" data-bs-toggle="modal" data-bs-target="#modal-pricing-contact">Solicitar ayuda</button>
      </div>
    </div>
  </div>
  
  {{-- Contact modal -----------------------------------------------------------}}
  <div class="modal fade" id="modal-pricing-contact" tabindex="-1" aria-labelledby="modal-pricing-contact-label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <form method="POST" action="{{ route('support.submit') }}">
          {{ csrf_field() }}
          <div class="modal-header border-0">
            <h5 class="modal-title" id="modal-pricing-contact-label">Solicitar ayuda o más información</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            @guest
            <div class="mb-3">
              <label for="input-name" class="form-label">Tu nombre</label>
              <input type="text" class="form-control" id="input-name" name="name" required maxlength="50">
            </div>
            <div class="mb-3">
              <label for="input-email" class="form-label">Tu correo electrónico</label>
              <input type="email" class="form-control" id="input-email" name="email" required>
            </div>
            @endguest
            <div class="mb-3">
              <label for="input-email" class="form-label">¿Cómo podemos ayudarte?</label>
              <textarea class="form-control" name="user_message" rows="4" required></textarea>
            </div>
            <p>Te contactaremos por correo electrónico a la brevedad posible.</p>
            <p>Si lo prefieres, puedes dejarnos otra información de contacto como tu número para WhatsApp o llamada telefónica.</p>
          </div>
          <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Enviar mensaje</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
</section>
