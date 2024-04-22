<div class="card mb-4 animate__animated animate__bounceIn">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-7">
                <h3 class="mb-3 text-dark">Acción recomendada</h3>
                <p>Empieza la academia en {{ config('app.name') }} iniciando tu primer examen de clasificación.</p>
                <a class="btn btn-primary" href="{{ route('academy.create.qualifying') }}">Iniciar examen de clasificación</a>
            </div>
            <div class="col-lg-5 d-flex text-center">
                <img class="img-fluid m-auto" src="{{ asset('/img/illustrations/recommended-action.jpeg') }}" alt="Atención en recepción" style="max-height: 200px;" >
            </div>

        </div>
    </div>
</div>
