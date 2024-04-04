<!-- Sidebar wrapper start -->
<nav class="sidebar-wrapper">
    <!-- Sidebar menu starts -->
    <div class="sidebar-menu">
        <div class="sidebarMenuScroll">
            <ul>
                <li class="{{ Request::is('dashboard') ? 'active-page-link':''  }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="bi bi-house"></i>
                        <span class="menu-text">Panel de Administrador</span>
                    </a>
                </li>
                <li class="{{ Request::is('empresa-dashboard') ? 'active-page-link':''  }}">
                    <a href="{{ url('empresa-dashboard') }}">
                        <i class="bi bi-layout-text-window-reverse"></i>
                        <span class="menu-text">Panel de {{ $empresa->nombre }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/') }}">
                        <i class="bi bi-globe"></i>
                        <span class="menu-text">Sitio Web</span>
                    </a>
                </li>
                <li class="{{ Request::is('users','show-user/*','add-user','edit-user/*') ? 'active-page-link':''  }}">
                    <a href="{{ url('users') }}">
                        <i class="bi bi-shield"></i>
                        <span class="menu-text">Administradores</span>
                    </a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-building"></i>
                        <span class="menu-text">Empresas</span>
                        {{-- <span class="badge red">15</span> --}}
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ url('usuarios') }}"><i class="bi bi-people-fill"></i> Usuarios</a>
                            </li>
                        </ul>
                        <ul>
                            <li class="{{ Request::is('empresas','show-empresa/*','add-empresa','edit-empresa/*') ? 'active-page-link':''  }}">
                                <a href="{{ url('empresas') }}"><i class="bi bi-building"></i> Empresas</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="{{ Request::is('config') ? 'active-page-link':''  }}">
                    <a href="{{ url('config') }}">
                        <i class="bi bi-gear"></i>
                        <span class="menu-text">Configuración</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->
