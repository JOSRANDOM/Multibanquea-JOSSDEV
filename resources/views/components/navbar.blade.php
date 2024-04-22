<nav class="navbar sticky-top navbar-light bg-white border-bottom">
  <div class="container-md">
    <a class="navbar-brand p-0" href="{{ route('welcome') }}" title="Ir a la página principal">
      <img src="{{ asset('/img/brand/' . config('variant.name') . '/logo-color-300.png') }}" alt="{{ config('app.name') }}" height="30">
    </a>

    @auth
    <a class="btn btn-light rounded-circle" href="{{ route('home') }}" title="Ir a la página principal">
      <i class="fal fa-user"></i>
    </a>
    @else
    <a class="btn btn-primary" href="{{ route('login') }}" title="Registrarse o iniciar sesión"><i class="bi bi-person-circle"></i> Ingresar</a>
    @endauth

  </div>
</nav>
