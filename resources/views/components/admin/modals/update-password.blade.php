<div class="modal fade" id="modal-update-password" tabindex="-1" aria-labelledby="modal-update-password"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.password.update', $user) }}">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title">Actualizar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <div><b>Usuario: {{ $user->name }}</b></div>
                        <div class="small"><span class="text-muted"><b>ID: </b></span> {{ $user->id }}</div>
                        <input name="user" value="{{ $user->id }}" hidden>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva contraseña</label>
                        <input type="text" class="form-control" id="password" name="password" required>
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
