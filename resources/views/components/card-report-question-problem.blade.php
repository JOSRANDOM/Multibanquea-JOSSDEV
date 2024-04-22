<div class="card card-body bg-dark mb-4">
  <a class="text-white opacity-3" href="#" data-bs-toggle="modal" data-bs-target="#modal-report-question-problem-{{ $question->id }}">
    <i class="fal fa-flag me-2"></i>Reportar un problema
  </a>
</div>

<x-modal-report-question-problem :question="$question" />
