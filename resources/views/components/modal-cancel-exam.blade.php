<div class="modal fade" id="modal-cancel-exam-{{ $exam->id }}" tabindex="-1"
  aria-labelledby="modal-cancel-exam-{{ $exam->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('exams.destroy', $exam) }}">

        @csrf
        @method('DELETE')

        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-cancel-exam-{{ $exam->id }}-label">Cancelar examen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <p>¿Estás segura/o que deseas eliminar este examen?</p>
          <p>Tus respuestas no se incluirán en tu progreso o en tus análisis personalizados.</p>

          @if(!Auth::user()->isSubscribed())
          <p>Para crear <b>exámenes ilimitados</b>, <a href="{{ route('subscriptions.index') }}">obtén acceso total
              aquí</a>.</p>
          @endif

        </div>

        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Cancelar examen</button>
        </div>

      </form>
    </div>
  </div>
</div>
