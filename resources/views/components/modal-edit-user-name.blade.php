<div class="modal fade" id="modal-edit-name" tabindex="-1" aria-labelledby="modal-edit-name" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('my-account.update-name') }}">

        @csrf

        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-edit-name-label">Cambiar nombre</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div>
            <label for="input-name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="input-name" name="name" aria-describedby="input-name-help" value="{{ Auth::user()->name }}" required>
            <div id="input-name-help" class="form-text">No puede incluir palabras ofensivas o sugerentes de cualquier tipo.</div>
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
