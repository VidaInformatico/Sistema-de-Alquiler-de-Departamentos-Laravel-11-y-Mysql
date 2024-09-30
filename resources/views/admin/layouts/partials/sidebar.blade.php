<nav class="sidebar sidebar-offcanvas bg-dark" data-bs-theme="dark" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="{{route('profile.edit')}}" class="nav-link text-white">
                <div class="nav-profile-image">
                    @if (Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" width="100">
                    @else
                        <img src="{{ asset('assets/admin/images/faces/face1.jpg') }}" alt="profile" width="100">
                    @endif
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    @auth
                        <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
                        <span class="text-secondary text-small">{{ Auth::user()->email }}</span>
                    @else
                        <span class="font-weight-bold mb-2">Guest</span>
                        <span class="text-secondary text-small">Please Login</span>
                    @endauth
                </div>
                <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('dashboard') }}">
                <span class="menu-title">Tablero</span>
                <i class="mdi mdi-home menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#ui-caja" aria-expanded="false"
                aria-controls="ui-caja">
                <span class="menu-title">Caja</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-cash menu-icon"></i>
            </a>
            <div class="collapse" id="ui-caja">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('cashboxs.index') }}">Caja</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('expenses.index') }}">Gastos</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('properties.index') }}">
                <span class="menu-title">Propiedades</span>
                <i class="mdi mdi-calendar menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('clients.index') }}">
                <span class="menu-title">Clientes</span>
                <i class="mdi mdi-account-group menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" data-bs-toggle="collapse" href="#ui-habitacion" aria-expanded="false"
                aria-controls="ui-habitacion">
                <span class="menu-title">Habitaciones</span>
                <i class="menu-arrow"></i>
                <i class="mdi mdi-room-service menu-icon"></i>
            </a>
            <div class="collapse" id="ui-habitacion">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('types.index') }}">Tipos</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('rooms.index') }}">Habitación</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('rentals.index') }}">
                <span class="menu-title">Alquileres</span>
                <i class="mdi mdi-calendar-alert menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('users.index') }}">
                <span class="menu-title">Usuarios</span>
                <i class="mdi mdi-account menu-icon"></i>
            </a>
        </li>

    </ul>
</nav>
