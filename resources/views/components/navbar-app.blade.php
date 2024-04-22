<nav id="sidebarMenu" class="d-md-block collapse app-navbar shadow px-3">
  <div class="position-sticky">
    <ul class="nav flex-column mt-3">
      <li class="nav-item mb-2 {{ Request::is('app*') ? 'active' : '' }}">
        <a href="{{ route('home') }}" class="nav-link rounded">
          <i class="bi bi-house-door-fill"></i>
          <span>Inicio</span>
        </a>
      </li>
      <li class="nav-item mb-2 {{ Request::is('progreso*') ? 'active' : '' }}">
        <a href="{{ route('statistics.index') }}" class="nav-link rounded">
          <i class="bi bi-graph-up-arrow"></i>
          <span>Progreso</span>
        </a>
      </li>
      <li class="nav-item mb-2 {{ Request::is('examenes*') ? 'active' : '' }}">
        <a href="{{ route('exams.index') }}" class="nav-link rounded">

          <i class="bi bi-journal-bookmark-fill"></i>
          <span>Exámenes</span>
        </a>
      </li>
        @if (env('ACTIVE_ACADEMY'))
        <li class="nav-item mb-2 {{ Request::is('academy*') ? 'active' : '' }}">
            <a href="{{ route('academy.index') }}" class="nav-link rounded">
                <i class="bi bi-bookmark-star"></i>
                <span>Academia</span>
            </a>
        </li>
        @endif
      @if (Auth::user()->isSubscribedWithCourses())
      <li class="nav-item mb-2 {{ Request::is('cursos*') ? 'active' : '' }}">
          <a href="{{ route('courses.index') }}" class="nav-link rounded">
            <i class="bi bi-journal-text"></i>
            <span>Mis Cursos</span>
          </a>
      </li>
      @endif
      @if(Auth::user()->study_id=='')
      <li class="nav-item mb-2 {{ Request::is('suscripcion*') ? 'active' : '' }}">
        <a href="{{ route('subscriptions.index') }}" class="nav-link rounded">
          <i class="bi bi-credit-card-fill"></i>
          <span>Suscripción</span>
        </a>
      </li>
      @endif
      <li class="nav-item mb-2 {{ Request::is('mi-cuenta*') ? 'active' : '' }}">
        <a href="{{ route('my-account.index') }}" class="nav-link rounded">
          <i class="bi bi-person-fill"></i>
          <span>Mi cuenta</span>
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="{{ route('logout') }}" class="nav-link rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="bi bi-box-arrow-left"></i>
            <span>Cerrar sesión</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>
