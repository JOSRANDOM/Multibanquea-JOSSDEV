<div class="modal fade" id="modal-edit-user-slug-{{ $user->id }}" tabindex="-1" aria-labelledby="modal-edit-user-slug-{{ $user->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.affiliates.update-slug') }}">

        @csrf
        @method('PUT')

        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-edit-user-slug-{{ $user->id }}-label">Cambiar identificador público</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <div><b>{{ $user->name }}</b></div>
            <div class="small"><span class="text-muted">ID:</span> {{ $user->id }}</div>
            <div class="small"><span class="text-muted">Identificador público:</span> {{ $user->slug }}</div>
            <input name="user" value="{{ $user->id }}" hidden>
          </div>

          <hr>

          <div>
            <label for="input-slug-{{ $user->id }}" class="form-label">Identificador público</label>
            <input type="text" class="form-control" id="input-slug-{{ $user->id }}" name="slug" value="{{ $user->slug }}" required>
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
