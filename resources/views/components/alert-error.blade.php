<div class="alert alert-danger d-flex gap-3 align-items-center" role="alert">
    <div class="h2 m-0"><i class="fal fa-fw fa-times"></i></div>
    <div>
        <h4 class="h6">¡Ups! Algo salió mal:</h4>
        <ul class="mb-0">
            @foreach ($errors as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
