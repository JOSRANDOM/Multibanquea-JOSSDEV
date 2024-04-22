<div class="card bg-dark text-white mb-4">
  <div class="card-body pb-2">
    <h3 class="h5 mb-3 opacity-4">Detalles de la pregunta</h3>

    @if ($question->source)
    <div class="mb-3 opacity-3">
      <i class="fal fa-fw me-1 fa-database"></i><b>Origen:</b> {{ $question->source }}
    </div>
    @endif

    <div class="mb-3 opacity-3">
      <i class="fal fa-fw fa-folder-open me-1"></i><b>Categoría:</b> {{ $question->getQuestionCategory->name }}
      <i class="fal fa-angle-right align-text-bottom"></i> {{ $question->question_subcategory->name }}
    </div>
    <div class="mb-3 opacity-3">
      <i class="fal fa-fw me-1 {{ $difficulty_icon }}"></i><b>Dificultad:</b> {{ $difficulty_label }}
    </div>
  </div>
</div>
