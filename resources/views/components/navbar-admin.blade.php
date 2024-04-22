<nav id="sidebarMenu" class="d-md-block collapse app-navbar shadow px-3">
  <div class="position-sticky">
    <ul class="nav flex-column mt-3">
      <li class="nav-item mb-2">
        <div class="nav-link disabled text-muted"><b>Administración</b></div>
      </li>
      <li class="nav-item mb-2 {{ Request::is('9PbqBgmI2f') ? 'active' : '' }}">
        <a href="{{ route('admin.index') }}" class="nav-link rounded">
          <span class="fal fa-fw me-2 opacity-2 fa-home-lg-alt"></span>
          <span>Inicio</span>
        </a>
      </li>

      @can('list affiliates')
      <li class="nav-item mb-2 {{ Request::is('9PbqBgmI2f/afiliados*') ? 'active' : '' }}">
        <a href="{{ route('admin.affiliates.index') }}" class="nav-link rounded">
          <span class="fal fa-fw me-2 opacity-2 fa-handshake"></span>
          <span>Afiliados</span>
        </a>
      </li>
      @endcan

      @can('list promo codes')
      <li class="nav-item mb-2 {{ Request::is('9PbqBgmI2f/codigos-promocionales*') ? 'active' : '' }}">
        <a href="{{ route('admin.promo-codes.index') }}" class="nav-link rounded">
          <span class="fal fa-fw me-2 opacity-2 fa-badge-percent"></span>
          <span>Códigos promocionales</span>
        </a>
      </li>
      @endcan

      @can('list permissions')
      <li class="nav-item mb-2 {{ Request::is('9PbqBgmI2f/roles*') ? 'active' : '' }}">
        <a href="{{ route('admin.roles.index') }}" class="nav-link rounded">
          <span class="fal fa-fw me-2 opacity-2 fa-users-cog"></span>
          <span>Roles administrativos</span>
        </a>
      </li>
      @endcan

      @can('list users')
      <li class="nav-item mb-2 {{ Request::is('9PbqBgmI2f/usuarios*') ? 'active' : '' }}">
        <a href="{{ route('admin.users.index') }}" class="nav-link rounded">
          <span class="fal fa-fw me-2 opacity-2 fa-users"></span>
          <span>Usuarios</span>
        </a>
      </li>
      @endcan

      @can('import students')
        <li class="nav-item mb-2 {{ Request::is('9PbqBgmI2f/importar-estudiantes*') ? 'active' : '' }}">
            <a href="{{ route('admin.import-students.index') }}" class="nav-link rounded">
                <span class="fal fa-fw me-2 opacity-2 fa-users"></span>
                <span>Importar Estudiantes</span>
            </a>
        </li>
      @endcan



      <li class="nav-item mb-2">
        <a href="{{ route('logout') }}" class="nav-link rounded" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <span class="fal fa-fw me-2 opacity-2 fa-sign-out-alt"></span>
          <span>Cerrar sesión</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>
