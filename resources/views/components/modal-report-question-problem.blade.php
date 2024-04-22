<div class="modal fade" id="modal-report-question-problem-{{ $question->id }}" tabindex="-1" aria-labelledby="modal-report-question-problem-label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('questions.report', $question) }}">
        {{ csrf_field() }}
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modal-report-question-problem-label">Reportar un problema</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>{{ __('Vas a reportar un problema con la siguiente pregunta:') }}</p>
          <p><b>{{ $question->text }}</b></p>
          <p>{{ __('Puedes agregar información adicional para ayudarnos a solucionarlo:') }}</p>
          <div>
            <label for="input-email" class="form-label">Información (opcional)</label>
            <textarea class="form-control" name="user_message" rows="4"></textarea>
          </div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Reportar</button>
        </div>
      </form>
    </div>
  </div>
</div>
