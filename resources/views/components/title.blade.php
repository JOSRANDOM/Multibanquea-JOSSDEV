<nav class="mx-n3 px-3 pt-4 pb-5 mb-n4 mx-md-n5 px-md-5">
  <div class="d-flex">
    <h1 class="h4 m-0 text-white w-100">{{ $label }}
        @if ($previousUrl)
        <a class="btn btn-danger btn-sm float-end" href="{{ $previousUrl }}" title="Volver"><i class="bi bi-arrow-return-left"></i> Volver</a>
        @endif
    </h1>
  </div>
  <div class="text-white opacity-3">{{ $description }}</div>
</nav>
