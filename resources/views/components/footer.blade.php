<footer class="py-4 bg-dark text-white text-md-center">
  <div class="container">
    <ul class="list-inline mb-3">
      <li class="list-inline-item">
        <a class="text-white opacity-2" href="#" data-bs-toggle="modal" data-bs-target="#modal-contact">Contacto</a>
      </li>
      <li class="list-inline-item">
        <a class="text-white opacity-2" href="{{ route('affiliates.index') }}">Programa de afiliados</a>
      </li>
      <li class="list-inline-item">
        <a class="text-white opacity-2" href="{{ route('legal.terms') }}">Aviso legal y condiciones de uso</a>
      </li>
    </ul>
    <div>© {{ now()->year }} {{ config('app.name') }}, Benlos S.A.C. Todos los derechos reservados.</div>
  </div>
</footer>

{{-- Contact modal -----------------------------------------------------------}}
<div class="modal fade" id="modal-contact" tabindex="-1" aria-labelledby="modal-contact-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('support.submit') }}">
        {{ csrf_field() }}
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-contact-label">Contáctanos</h5>
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
            <label for="input-email" class="form-label">Tu mensaje</label>
            <textarea class="form-control" name="user_message" rows="4" required></textarea>
          </div>
          <p>Te responderemos por correo electrónico a la brevedad posible.</p>
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
