<div class="modal fade" id="modal-deactivate-affiliate-{{ $user->id }}" tabindex="-1" aria-labelledby="modal-deactivate-affiliate-{{ $user->id }}-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.affiliates.update') }}">

        @csrf
        @method('PUT')

        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-deactivate-affiliate-{{ $user->id }}-label">Desactivar afiliado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <div><b>{{ $user->name }}</b></div>
            <div class="small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
            <div class="small"><span class="text-muted">Identificador público:</span> {{ $user->slug }}</div>
            <input name="user" value="{{ $user->id }}" hidden>
            <input name="active" value="0" hidden>
          </div>

          <hr>

          <p>¿Estás seguro que deseas desactivar este afiliado?</p>
          <p>El usuario será removido del programa de afiliados, pero podrá ser agregado nuevamente en el futuro.</p>
        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Desactivar</button>
        </div>

      </form>
    </div>
  </div>
</div>
