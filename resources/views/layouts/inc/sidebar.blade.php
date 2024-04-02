<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 ps bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header text-center">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('/dashboard') }}" target="_blank">
            <img src="{{ asset('elearning/img/logos/logohorizontal.png') }}" class="navbar-brand-img h-100" alt="E-Shop">
            {{-- <i class="material-icons opacity-10">storefront</i> --}}
            {{-- <span class="ms-1 font-weight-bold text-white">Buro</span> --}}
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('/') ? 'active bg-gradient-info':''  }}"
                    href="{{ url('/') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">storefront</i>
                    </div>
                    <span class="nav-link-text ms-1">Shop</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('dashboard') ? 'active bg-gradient-info':''  }}"
                    href="{{ url('/dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Panel de Control') }}</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('categories','add-category') ? 'active bg-gradient-info':''  }}" href="{{ url('categories') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">category</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Categories') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('products','add-product') ? 'active bg-gradient-info':''  }}" href="{{ url('products') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">sell</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Products') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('orders','order-history') ? 'active bg-gradient-info':''  }}" href="{{ url('orders') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_shipping</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Orders') }}</span>
                </a>
            </li> --}}
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('instructors','show-instructor/*','add-instructor','edit-instructor/*') ? 'active bg-gradient-info':''  }}" href="{{ url('instructors') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">school</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Instructores') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('course-categories','show-course-category/*','add-course-category','edit-course-category/*') ? 'active bg-gradient-info':''  }}" href="{{ url('course-categories') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">category</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Categorías') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('index-courses','show-course/*','add-course','edit-course/*') ? 'active bg-gradient-info':''  }}" href="{{ url('index-courses') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">local_library</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Contenido') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('index-subscriptions','show-subscription/*') ? 'active bg-gradient-info':''  }}" href="{{ url('index-subscriptions') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">workspace_premium</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Suscripciones') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('users','add-user') ? 'active bg-gradient-info':''  }}" href="{{ url('users') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">people_alt</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Usuarios') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('config') ? 'active bg-gradient-info':''  }}" href="{{ url('config') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">settings</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Configuración') }}</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">{{ __('Account') }}</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Request::is('show-user/'.Auth::id(),'edit-user/'.Auth::id()) ? 'active bg-gradient-info':''  }}" href="{{ url('show-user/'.Auth::id()) }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">person</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Mi Perfil') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white " href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">logout</i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Cerrar Sesión') }}</span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link text-white " href="{{ asset('dashtemplate/pages/sign-up.html') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">assignment</i>
                    </div>
                    <span class="nav-link-text ms-1">Sign Up</span>
                </a>
            </li> --}}
        </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
        <div class="mx-3">
          <a class="btn bg-gradient-primary mt-4 w-100" href="{{ url('/') }}" type="button"><i class="material-icons opacity-10">language</i> {{ __('Ir a la web') }}</a>
        </div>
    </div>
</aside>
