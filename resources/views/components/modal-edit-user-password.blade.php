<div class="modal fade" id="modal-edit-user-password" tabindex="-1" aria-labelledby="modal-edit-user-password" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('my-account.update-password') }}">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="modal-edit-name-label">Cambiar Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="input-name" class="form-label">Contraseña actual</label>
                        <input type="password" class="form-control" id="current-password" name="current-password" required>
                    </div>
                    <div>
                        <label for="input-name" class="form-label">Nueva contraseña</label>
                        <input type="password" class="form-control" id="new-password" name="new-password" required>
                    </div>
                    <div>
                        <label for="input-name" class="form-label">Confirmar nueva contraseña</label>
                        <input type="password" class="form-control" id="new-confirm-password" name="new-confirm-password" required>
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
