<div class="modal fade" id="modal-edit-phone" tabindex="-1" aria-labelledby="modal-edit-phone" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('my-account.update-phone') }}">

        @csrf

        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-edit-name-label">Cambiar número</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div>
            <label for="input-name" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="input-phone" name="phone" aria-describedby="input-phone-help" value="{{ Auth::user()->phone }}" required>
            <div id="input-phone-help" class="form-text">No puede incluir palabras ofensivas o sugerentes de cualquier tipo.</div>
          </div>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>

      </form>
    </div>
  </div>
</div>
