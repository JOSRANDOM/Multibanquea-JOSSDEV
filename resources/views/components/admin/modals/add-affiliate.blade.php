<div class="modal fade" id="modal-add-affiliate" tabindex="-1" aria-labelledby="modal-add-affiliate" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.affiliates.store') }}">

        @csrf

        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-add-affiliate-label">Agregar un afiliado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="input-user" class="form-label">ID del usuario</label>
            <input type="number" class="form-control" id="input-user" name="user" required>
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
