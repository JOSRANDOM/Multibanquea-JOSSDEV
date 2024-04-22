 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        {{-- <div class="sidebar-brand-icon rotate-n-15"> --}}
        <div class="sidebar-brand-icon "">
            {{-- <i class="fas fa-person-pregnant"></i> --}}
            <i class="fab fa-behance"></i>
            {{-- <i class="bi bi-behance"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">{{ env('APP_NAME')}} <sup>v2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::is('9PbqBgmI2f') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    @can('list users')
    <div class="sidebar-heading">
        USUARIOS
    </div>
    <li class="nav-item {{ Request::is('9PbqBgmI2f/usuarios*') ? 'active' : '' }}">
      <a href="{{ route('admin.users.index') }}" class="nav-link">
        <i class="fas fa-fw fa-users"></i>
        <span>Usuarios</span>
      </a>
    </li>
    @endcan
    @can('import students')
    <li class="nav-item {{ Request::is('9PbqBgmI2f/importar-estudiantes*') ? 'active' : '' }}">
        <a href="{{ route('admin.import-students.index') }}" class="nav-link">
            <i class="fs-6 bi bi-person-down"></i>
            <span>Importar Estudiantes</span>
        </a>
    </li>
    @endcan
    @can('list permissions')
    <li class="nav-item {{ Request::is('9PbqBgmI2f/roles*') ? 'active' : '' }}">
      <a href="{{ route('admin.roles.index') }}" class="nav-link ">
        <i class="fs-6 bi bi-person-gear"></i>
        <span>Roles administrativos</span>
      </a>
    </li>
    @endcan
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        NOTIFICACIONES
    </div>
    <li class="nav-item {{ Request::is('9PbqBgmI2f/configuracion-notificaciones*') ? 'active' : '' }}">
        <a href="{{ route('admin.notifications_settings.index') }}" class="nav-link">
            <i class="fs-6 bi bi-gear"></i>
            <span>Configuración</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('9PbqBgmI2f/notificaciones*') ? 'active' : '' }}">
        <a href="{{ route('admin.notifications.index') }}" class="nav-link">
            <i class="fs-6 bi bi-send-fill"></i>
            <span>Notificationes</span>
        </a>
    </li>
    <!-- Heading -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        SUBSCRIPCIONES
    </div>
    @can('list promo codes')
    <li class="nav-item {{ Request::is('9PbqBgmI2f/codigos-promocionales*') ? 'active' : '' }}">
        <a href="{{ route('admin.promo-codes.index') }}" class="nav-link">
            <i class="fs-6 bi bi-percent"></i>
            <span>Códigos promocionales</span>
        </a>
    </li>
    @endcan
    <li class="nav-item {{ Request::is('9PbqBgmI2f/checkout_references*') ? 'active' : '' }}">
        <a href="{{ route('admin.checkout_references.index') }}" class="nav-link">
            <i class="bi bi-credit-card"></i>
            <span>Compras</span>
        </a>
    </li>
    {{-- @can('list plans') --}}
    <li class="nav-item {{ Request::is('9PbqBgmI2f/planes*') ? 'active' : '' }}">
      <a href="{{ route('admin.plans.index') }}" class="nav-link">
        <i class="bi bi-credit-card"></i>

        <span>Planes</span>
      </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Examenes
    </div>
    <li class="nav-item {{ Request::is('9PbqBgmI2f/categorias*') ? 'active' : '' }}">
        <a href="{{ route('admin.question_categories.index') }}" class="nav-link">
            <i class="bi bi-card-checklist"></i>
            <span>Categorías</span>
        </a>
    </li>
    <li class="nav-item {{ Request::is('9PbqBgmI2f/subcategorias*') ? 'active' : '' }}">
        <a href="{{ route('admin.question_subcategories.index') }}" class="nav-link">
            <i class="bi bi-card-checklist"></i>
            <span>Subategorías</span>
        </a>
    </li>
    {{-- @endcan --}}
{{--
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="buttons.html">Buttons</a>
                <a class="collapse-item" href="cards.html">Cards</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="utilities-color.html">Colors</a>
                <a class="collapse-item" href="utilities-border.html">Borders</a>
                <a class="collapse-item" href="utilities-animation.html">Animations</a>
                <a class="collapse-item" href="utilities-other.html">Other</a>
            </div>
        </div>
    </li> --}}



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
<!-- End of Sidebar -->
