<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-g" />
        <title>BioClinik - Gestión de Mantenimiento</title>
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('vendors/images/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('vendors/images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('vendors/images/favicon-16x16.png') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/core.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/icon-font.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('deskapp/plugins/datatables/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('deskapp/plugins/datatables/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/styles/style.css') }}">
    </head>
    <body>
        <div class="header">
            <div class="header-left">
                <div class="menu-icon bi bi-list"></div>
                @if(Auth::user()->hasPermission('report_failure'))
                <div class="ml-3">
                    <a href="{{ route('maintenance-requests.create') }}" class="btn btn-danger btn-sm">
                        <i class="bi bi-exclamation-triangle-fill"></i> Reportar Falla
                    </a>
                </div>
                @endif
            </div>
            <div class="header-right">
                <div class="user-info-dropdown">
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                            <span class="user-icon"><img src="{{ asset('vendors/images/photo1.jpg') }}" alt="" /></span>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                            <a class="dropdown-item" href="#"><i class="dw dw-user1"></i> Perfil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="dw dw-logout"></i> Cerrar Sesión
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="left-side-bar">
            <div class="brand-logo">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo" />
                    <img src="{{ asset('vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo" />
                </a>
                <div class="close-sidebar" data-toggle="left-sidebar-close"><i class="ion-close-round"></i></div>
            </div>
            <div class="menu-block customscroll">
                <div class="sidebar-menu">
                    <ul id="accordion-menu">
                        @if(Auth::user()->hasPermission('view_dashboard'))
                        <li><a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow {{ request()->routeIs('dashboard') ? 'active' : '' }}"><span class="micon bi bi-speedometer2"></span><span class="mtext">Dashboard</span></a></li>
                        @endif

                        @if(Auth::user()->hasPermission('view_my_tasks'))
                        <li><a href="{{ route('dashboard.my-tasks') }}" class="dropdown-toggle no-arrow {{ request()->routeIs('dashboard.my-tasks') ? 'active' : '' }}"><span class="micon bi bi-list-task"></span><span class="mtext">Mis Tareas</span></a></li>
                        @endif

                        @if(Auth::user()->hasPermission('access_settings_menu'))
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-gear"></span><span class="mtext">Configuración</span></a>
                            <ul class="submenu">
                                @if(Auth::user()->hasPermission('manage_ips'))<li><a href="{{ route('ips.index') }}" class="{{ request()->routeIs('ips.*') ? 'active' : '' }}">Gestionar IPS</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_sedes'))<li><a href="{{ route('sedes.index') }}" class="{{ request()->routeIs('sedes.*') ? 'active' : '' }}">Gestionar Sedes</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_servicios'))<li><a href="{{ route('servicios.index') }}" class="{{ request()->routeIs('servicios.*') ? 'active' : '' }}">Gestionar Servicios</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_zonas'))<li><a href="{{ route('zonas.index') }}" class="{{ request()->routeIs('zonas.*') ? 'active' : '' }}">Gestionar Zonas</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_roles'))<li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">Gestionar Roles</a></li>@endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermission('access_security_menu'))
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-shield-lock"></span><span class="mtext">Seguridad</span></a>
                            <ul class="submenu">
                                @if(Auth::user()->hasPermission('manage_users'))<li><a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Gestión de Usuarios</a></li>@endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermission('access_inventory_menu'))
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-box-seam"></span><span class="mtext">Inventario</span></a>
                            <ul class="submenu">
                                @if(Auth::user()->hasPermission('manage_asset_types'))<li><a href="{{ route('asset-types.index') }}" class="{{ request()->routeIs('asset-types.*') ? 'active' : '' }}">Gestionar Tipos de Activo</a></li>@endif
                                @if(Auth::user()->hasPermission('view_assets'))<li><a href="{{ route('assets.index') }}" class="{{ request()->routeIs('assets.*') ? 'active' : '' }}">Gestión de Activos</a></li>@endif
                                @if(Auth::user()->hasPermission('view_spare_part_requests'))<li><a href="{{ route('spare-part-requests.index') }}" class="{{ request()->routeIs('spare-part-requests.*') ? 'active' : '' }}">Repuestos Solicitados</a></li>@endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermission('access_operations_menu'))
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-tools"></span><span class="mtext">Operaciones</span></a>
                            <ul class="submenu">
                                @if(Auth::user()->hasPermission('view_maintenance_requests'))<li><a href="{{ route('maintenance-requests.index') }}" class="{{ request()->routeIs('maintenance-requests.*') ? 'active' : '' }}">Ver Solicitudes</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_maintenance_reports'))<li><a href="{{ route('maintenance-reports.index') }}" class="{{ request()->routeIs('maintenance-reports.*') ? 'active' : '' }}">Reportes de Manto.</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_task_teams'))<li><a href="{{ route('task-teams.index') }}" class="{{ request()->routeIs('task-teams.*') ? 'active' : '' }}">Equipos de Tarea</a></li>@endif
                                @if(Auth::user()->hasPermission('view_failures_list'))<li><a href="{{ route('failures.index') }}" class="{{ request()->routeIs('failures.*') ? 'active' : '' }}">Listado de Fallas</a></li>@endif
                                @if(Auth::user()->hasPermission('attend_failures'))<li><a href="{{ route('dashboard.my-tasks') }}" class="{{ request()->routeIs('dashboard.my-tasks') ? 'active' : '' }}">Atención de Fallas</a></li>@endif
                            </ul>
                        </li>
                        @endif

                        @if(Auth::user()->hasPermission('manage_schedules'))
                        <li><a href="{{ route('schedules.index') }}" class="dropdown-toggle no-arrow {{ request()->routeIs('schedules.*') ? 'active' : '' }}"><span class="micon bi bi-calendar-week"></span><span class="mtext">Cronogramas</span></a></li>
                        @endif

                        @if(Auth::user()->hasPermission('access_protocols_menu'))
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle"><span class="micon bi bi-clipboard2-check"></span><span class="mtext">Protocolos y Tests</span></a>
                            <ul class="submenu">
                                @if(Auth::user()->hasPermission('manage_hospital_rounds'))<li><a href="{{ route('hospital-rounds.index') }}" class="{{ request()->routeIs('hospital-rounds.*') ? 'active' : '' }}">Ronda Hospitalaria</a></li>@endif
                                @if(Auth::user()->hasPermission('manage_defibrillator_tests'))<li><a href="{{ route('defibrillator-tests.index') }}" class="{{ request()->routeIs('defibrillator-tests.*') ? 'active' : '' }}">Test de Desfibriladores</a></li>@endif
                            </ul>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile-menu-overlay"></div>

        <div class="main-container">
            <div class="pd-ltr-20">
                @yield('content')
                <div class="footer-wrap pd-20 mb-20 card-box">
                    BioClinik - Sistema de Gestión de Mantenimiento Hospitalario
                </div>
            </div>
        </div>
        <script src="{{ asset('vendors/scripts/core.js') }}"></script>
        <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
        <script src="{{ asset('vendors/scripts/process.js') }}"></script>
        <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
        @stack('scripts')
    </body>
</html>
