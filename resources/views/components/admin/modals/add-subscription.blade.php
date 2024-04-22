<div class="modal fade" id="modal-add-subscription" tabindex="-1" aria-labelledby="modal-add-subscription"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.users.subscriptions.store', $user) }}">

        @csrf

        <div class="modal-header border-0">
          <h5 class="modal-title">Agregar suscripción</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <div><b>{{ $user->name }}</b></div>
            <div class="small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
            <input name="user" value="{{ $user->id }}" hidden>
          </div>

          <hr>

          <div class="mb-3">
            <label for="select-type" class="form-label">Tipo de plan</label>
            <select id="select-type" class="form-select" name="type" required>
              <option value="afiliados">Programa de afiliados</option>
              <option value="afiliados-cursos">Programa de afiliados + Cursos</option>
              <option value="sorteo">Sorteo</option>
              <option value="trabajador">Trabajador</option>
              <option value="colaborador">Colaborador</option>
              <option value="pago-manual">Pago manual</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="input-months" class="form-label">Meses</label>
            <input type="number" class="form-control" value="1" id="input-months" name="months" required>
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
