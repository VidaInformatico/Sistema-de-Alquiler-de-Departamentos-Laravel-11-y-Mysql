<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center bg-dark navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="/"><img
                src="{{ asset('assets/admin/images/logo-mini.png') }}" alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="/"><img
                src="{{ asset('assets/admin/images/logo-mini.png') }}" alt="logo" /></a>
    </div>
    <div class="navbar-menu-wrapper bg-dark d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
        <div class="search-field d-none d-md-block">
            {{-- <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                    <div class="input-group-prepend bg-transparent">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
                </div>
            </form> --}}
        </div>
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <div class="nav-profile-img">
                        @if (Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" width="100">
                        @else
                            <img src="{{ asset('assets/admin/images/faces/face1.jpg') }}" alt="profile" width="100">
                        @endif
                        <span class="availability-status online"></span>
                    </div>
                    <div class="nav-profile-text">
                        @auth
                            <p class="mb-1 text-white">{{ Auth::user()->name }}</p>
                        @else
                            <p class="mb-1 text-white">Guest</p>
                        @endauth
                    </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                    <a class="dropdown-item" href="{{route('profile.edit')}}">
                        <i class="mdi mdi-cached me-2 text-success"></i> Perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    @auth
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout me-2 text-primary"></i> Salir
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endauth
                </div>
            </li>
            <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                    <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
            </li>

            {{-- mensajes --}}

            {{-- notificaciones --}}

            <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" href="#">
                    <i class="mdi mdi-format-line-spacing"></i>
                </a>
            </li>
        </ul>

        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
            data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
