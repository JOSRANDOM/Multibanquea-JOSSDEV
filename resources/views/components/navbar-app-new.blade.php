<nav id="sidebarMenu" class="d-md-block collapse app-navbar shadow px-3">
    <div class="position-sticky">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start flex-column mt-3" id="menu">
            <li class="nav-item mb-2 w-100 {{ Request::is('app*') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link text-white rounded">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-sm-inline">Inicio</span>
                </a>
            </li>
            {{-- <li class="nav-item mb-2 w-100 {{ Request::is('progreso*') ? 'active' : '' }}">
                <a href="{{ route('statistics.index') }}" class="nav-link rounded text-white">
                  <i class="fs-4 bi-graph-up-arrow"></i> <span class="ms-1 d-sm-inline">Progreso</span>
                </a>
            </li> --}}
            @if (env('ACTIVE_STATS',0))
            <li class="nav-item mb-2 w-100 {{ Request::is('estadisticas*') ? 'active' : '' }}">
                <a href="{{ route('statistics.index.new') }}" class="nav-link rounded text-white">
                    <i class="fs-4 bi-bar-chart-line-fill"></i> <span class="ms-1 d-sm-inline">Estadísticas</span>
                </a>
            </li>
            @endif
            <li class="nav-item mb-2 w-100 {{ Request::is('examenes*') ? 'active' : '' }}">
                <a href="{{ route('exams.index') }}" class="nav-link align-middle text-white">
                  <i class="fs-4 bi-journal-bookmark-fill"></i> <span class="ms-1 d-sm-inline">Exámenes</span>
                </a>
            </li>
            @if (env('ACTIVE_FLASH_CARDS',0))
            <li class="nav-item mb-2 w-100 {{ Request::is('flash-cards*') ? 'active' : '' }}">
                <a href="{{ route('flash-cards.index') }}" class="nav-link align-middle text-white">
                    <i class="fs-4 bi-postcard-heart-fill"></i> <span class="ms-1 d-sm-inline">Flash cards</span>
                </a>
            </li>
            @endif
            @if (env('ACTIVE_ACADEMY',0))
            <li class="nav-item mb-2 w-100 ">
                <a href="#submenu3" data-bs-toggle="collapse" class="nav-link text-white align-middle mb-2 {{ Request::is('academia*') ? 'active' : '' }}" >
                    <i class="fs-4 bi-bookmark-star"></i> <span class="ms-1 d-sm-inline">Academia</span>
                </a>
                <ul class="collapse {{ Request::is('academia*') ? 'show' : '' }} nav flex-column ms-1" id="submenu3" data-bs-parent="#menu">
                    <li class="mb-2 w-100">
                        <a href="{{ route('academy.index') }}" class="nav-link text-white {{ Route::is('academy.index') ? 'active' : '' }}"><i class="bi bi-circle"></i> <span class="d-sm-inline">Resumen</span></a>
                    </li>
                    <li class="mb-2 w-100">
                        <a href="#" class="nav-link text-white"><i class="bi bi-circle"></i> <span class="d-sm-inline">Calendario</span></a>
                    </li class="mb-2 w-100">
                    <li class="mb-2 w-100">
                        <a href="#" class="nav-link text-white"><i class="bi bi-circle"></i> <span class="d-sm-inline">Estadísticas</span></a>
                    </li>
                </ul>
            </li>
            @endif
            @if (Auth::user()->isSubscribedWithCourses())
            <li class="nav-item mb-2 w-100 {{ Request::is('cursos*') ? 'active' : '' }}">
                <a href="{{ route('courses.index') }}" class="nav-link text-white align-middle">
                  <i class="fs-4 bi-journal-text"></i>
                  <span>Mis Cursos</span>
                </a>
            </li>
            @endif
            @if(Auth::user()->study_id=='')
            <li class="nav-item mb-2 w-100 {{ Request::is('suscripcion*') ? 'active' : '' }}">
                <a href="{{ route('subscriptions.index') }}" class="nav-link text-white align-middle">
                    <i class="fs-4 bi-credit-card-fill"></i>
                    <span class="ms-1 d-sm-inline">Suscripción</span>
                </a>
            </li>
            @endif

            <li class="nav-item mb-2 w-100 {{ Request::is('mi-cuenta*') ? 'active' : '' }}">
                <a href="{{ route('my-account.index') }}" class="nav-link align-middle text-white">
                  <i class="fs-4 bi-person-fill"></i> <span class="ms-1 d-sm-inline">Mi cuenta</span>
                </a>
            </li>
            <li class="nav-item mb-2 w-100">
                <a href="{{ route('logout') }}" class="nav-link align-middle text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fs-4 bi-box-arrow-left"></i> <span class="ms-1 d-sm-inline">Cerrar sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
        </ul>
    </div>
  </nav>
