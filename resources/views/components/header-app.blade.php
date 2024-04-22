<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap py-2 px-3" style="background: linear-gradient(90deg, #02555b, #01191b);">
    <a class="navbar-brand p-0" href="{{ route('home') }}" title="Ir a la página principal">
        <img src="{{ asset('/img/brand/' . config('variant.name') . '/logo-white-300.png') }}" alt="{{ config('app.name') }}" height="30">
    </a>

    <div>
        <ul class="navbar-nav flex-row ">

            @hasanyrole('super-admin|admin|moderator')
            <li class="me-3 nav-item text-nowrap">
                <a class="btn btn-dark rounded" href="{{ route('admin.index') }}" title="Ir a la página principal" style="background: rgba(255, 255 ,255 , 0.1)">
                    <i class="bi bi-person-gear"></i> <span class="d-none d-md-inline">Administración</span>
                </a>
            </li>
            @endhasanyrole

            <li class="nav-item text-nowrap">
                <a class="btn btn-dark rounded" href="{{ route('home') }}" title="Ir a la página principal" style="background: rgba(255, 255 ,255 , 0.1)">
                    <i class="bi bi-person-fill"></i> <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
            </li>
            <li class="nav-item ms-3 d-flex d-md-none align-items-stretch">
                <button class="navbar-toggler collapsed border-none text-white" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Mostrar u ocultar navegación" style="background: rgba(255, 255, 255, 0.1);">
                    <i class="bi bi-list"></i>
                </button>
            </li>
        </ul>
    </div>
</header>
