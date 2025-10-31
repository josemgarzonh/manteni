<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        <!-- Cronogramas -->
        <li class="nav-item">
            <a href="{{ route('schedules.calendar') }}" class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>Cronogramas</p>
            </a>
        </li>

        <!-- Inventario -->
        <li class="nav-item {{ request()->routeIs('assets.*') || request()->routeIs('asset-types.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('assets.*') || request()->routeIs('asset-types.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                    Inventario
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('assets.index') }}" class="nav-link {{ request()->routeIs('assets.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Equipos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('asset-types.index') }}" class="nav-link {{ request()->routeIs('asset-types.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tipos de Equipos</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Operaciones -->
        <li class="nav-item {{ request()->routeIs('maintenance-requests.*') || request()->routeIs('maintenance-reports.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('maintenance-requests.*') || request()->routeIs('maintenance-reports.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tools"></i>
                <p>
                    Operaciones
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('maintenance-requests.index') }}" class="nav-link {{ request()->routeIs('maintenance-requests.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Solicitudes Mantenimiento</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('maintenance-reports.index') }}" class="nav-link {{ request()->routeIs('maintenance-reports.index') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Reportes Mantenimiento</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('failures.index') }}" class="nav-link {{ request()->routeIs('failures.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Atención de Fallas</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Protocolos -->
        <li class="nav-item {{ request()->routeIs('hospital-rounds.*') || request()->routeIs('defibrillator-tests.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('hospital-rounds.*') || request()->routeIs('defibrillator-tests.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-clipboard-check"></i>
                <p>
                    Protocolos
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('hospital-rounds.index') }}" class="nav-link {{ request()->routeIs('hospital-rounds.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Rondas Hospitalarias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('defibrillator-tests.index') }}" class="nav-link {{ request()->routeIs('defibrillator-tests.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Tests Desfibriladores</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Equipos de Trabajo -->
        <li class="nav-item">
            <a href="{{ route('task-teams.index') }}" class="nav-link {{ request()->routeIs('task-teams.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Equipos de Trabajo</p>
            </a>
        </li>

        <!-- Repuestos -->
        <li class="nav-item">
            <a href="{{ route('spare-part-requests.index') }}" class="nav-link {{ request()->routeIs('spare-part-requests.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Solicitud Repuestos</p>
            </a>
        </li>

        <!-- Configuración -->
        @can('access_settings_menu')
        <li class="nav-item {{ request()->routeIs('ips.*') || request()->routeIs('sedes.*') || request()->routeIs('servicios.*') || request()->routeIs('zonas.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('ips.*') || request()->routeIs('sedes.*') || request()->routeIs('servicios.*') || request()->routeIs('zonas.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i>
                <p>
                    Configuración
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('ips.index') }}" class="nav-link {{ request()->routeIs('ips.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>IPS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sedes.index') }}" class="nav-link {{ request()->routeIs('sedes.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sedes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('servicios.index') }}" class="nav-link {{ request()->routeIs('servicios.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Servicios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('zonas.index') }}" class="nav-link {{ request()->routeIs('zonas.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Zonas</p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        <!-- Seguridad -->
        @can('access_security_menu')
        <li class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-shield-alt"></i>
                <p>
                    Seguridad
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Roles</p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        <!-- Mi Perfil -->
        <li class="nav-item">
            <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>Mi Perfil</p>
            </a>
        </li>

        <!-- Cerrar Sesión -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>Cerrar Sesión</p>
                </a>
            </form>
        </li>
    </ul>
</nav>

<style>
.nav-sidebar .nav-item > .nav-link.active {
    background-color: #007bff;
    color: #fff;
}
.nav-sidebar .nav-treeview .nav-item > .nav-link.active {
    background-color: rgba(255,255,255,.1);
    color: #fff;
}
</style>