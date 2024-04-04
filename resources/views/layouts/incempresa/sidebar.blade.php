<!-- Sidebar wrapper start -->
<nav class="sidebar-wrapper">
    <!-- Sidebar menu starts -->
    <div class="sidebar-menu">
        @if(Auth::user()->empresa->fotografia != '')
            <div align="center" class="brand">
                <img src="{{ asset('assets/uploads/empresas/'.Auth::user()->empresa->fotografia) }}" class="img-thumbnail" style="height: 50px;" alt="Logo" />
            </div>
        @else
        <div align="center" class="brand">
            <label class=" text-white">Empresa: <u>{{ Auth::user()->empresa->nombre }}</u></label><br>
        </div>
        @endif
        <div class="sidebarMenuScroll">
            <ul>

                @if(Auth::user()->role_as == 0)
                <li class="{{ Request::is('dashboard') ? 'active-page-link':''  }}">
                    <a href="{{ url('/dashboard') }}">
                        <i class="bi bi-house"></i>
                        <span class="menu-text">Panel de Administracion</span>
                    </a>
                </li>
                @endif

                <li class="{{ Request::is('empresa-dashboard') ? 'active-page-link':''  }}">
                    <a href="{{ url('empresa-dashboard') }}">
                        <i class="bi bi-layout-text-window-reverse"></i>
                        <span class="menu-text">Panel de {{ Auth::user()->empresa->nombre }}</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/') }}">
                        <i class="bi bi-globe"></i>
                        <span class="menu-text">Sitio Web</span>
                    </a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-building"></i>
                        <span class="menu-text">{{ Auth::user()->empresa->nombre }}</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li class="{{ Request::is('empresa-usuarios','show-empresa-usuario/*','add-empresa-usuario','edit-empresa-usuario/*') ? 'active-page-link':''  }}">
                                <a href="{{ url('empresa-usuarios') }}"><i class="bi bi-people-fill"></i> Usuarios</a>
                            </li>
                        </ul>
                        <ul>
                            <li class="{{ Request::is('show-empresa-info/*','edit-empresa-info/*') ? 'active-page-link':''  }}">
                                <a href="{{ url('show-empresa-info/'.Auth::user()->empresa_id) }}"><i class="bi bi-building"></i>Empresa</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="{{ Request::is('empresa-config') ? 'active-page-link':''  }}">
                    <a href="{{ url('empresa-config') }}">
                        <i class="bi bi-gear"></i>
                        <span class="menu-text">Configuración</span>
                    </a>
                </li>
                {{-- <li class="{{ Request::is('users','show-user/*','add-user','edit-user/*') ? 'active-page-link':''  }}">
                    <a href="{{ url('users') }}">
                        <i class="bi bi-shield"></i>
                        <span class="menu-text">Administradores</span>
                    </a>
                </li>
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="bi bi-building"></i>
                        <span class="menu-text">Empresas</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li class="{{ Request::is('usuarios','show-usuario/*','add-usuario','edit-usuario/*') ? 'active-page-link':''  }}">
                                <a href="{{ url('usuarios') }}"><i class="bi bi-people-fill"></i> Usuarios</a>
                            </li>
                        </ul>
                        <ul>
                            <li class="{{ Request::is('empresas','show-empresa/*','add-empresa','edit-empresa/*') ? 'active-page-link':''  }}">
                                <a href="{{ url('empresas') }}"><i class="bi bi-building"></i> Empresas</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
    <!-- Sidebar menu ends -->

</nav>
<!-- Sidebar wrapper end -->
