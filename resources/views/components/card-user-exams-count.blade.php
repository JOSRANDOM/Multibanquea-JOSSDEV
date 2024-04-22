<div class="card mb-4">
  <div class="card-body text-secondary">
    <h3 class="mb-3 text-dark">Tus exámenes iniciados</h3>

    @switch($user->exams()->count())
    @case(0)
    <div>Aún no has iniciado ningún examen.</div>
    @break
    @case(1)
    <div>Ya has iniciado tu primer examen. ¡Continúa preparándote con {{ config('app.name') }}!</div>
    @break
    @default
    <div>Hasta el momento has iniciado {{ $user->exams()->count() }} exámenes.</div>
    @endswitch

    <a class="btn btn-primary mt-3" href="{{ route('exams.index') }}">Mis exámenes</a>
  </div>
</div>
