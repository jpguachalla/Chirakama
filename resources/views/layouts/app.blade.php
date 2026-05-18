<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Chirakama Importadora</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    @stack('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="brand">
            CHIRA<span>KAMA</span>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
            </li>
            <li class="sidebar-nav-item mt-4 mb-2 px-3 text-muted small text-uppercase">Inventario</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('vehicles.index') }}" class="sidebar-nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front"></i> Vehículos
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('categories.index') }}" class="sidebar-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i> Categorías
                </a>
            </li>
            <li class="sidebar-nav-item mt-4 mb-2 px-3 text-muted small text-uppercase">Administración</li>
            <li class="sidebar-nav-item">
                <a href="{{ route('users.index') }}" class="sidebar-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Usuarios
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('roles.index') }}" class="sidebar-nav-link {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                    <i class="bi bi-shield-lock"></i> Roles
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <button class="btn btn-link text-white d-lg-none me-2" id="sidebarToggle">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <h4 class="mb-0 text-white fw-bold d-none d-md-block">@yield('page_header', 'Panel de Control')</h4>
            </div>

            <div class="navbar-user dropdown">
                <a href="#" class="dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="text-end d-none d-md-block me-2">
                        <div class="fw-bold text-white lh-1">Admin User</div>
                        <small class="text-gold">Super Admin</small>
                    </div>
                    <!-- Puedes reemplazar la URL de la imagen con la foto real del usuario desde Auth::user() -->
                    <img src="https://ui-avatars.com/api/?name=Admin+User&background=d4af37&color=000" alt="User">
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Mi Perfil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Configuración</a></li>
                    <li><hr class="dropdown-divider border-secondary"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" id="logoutBtn">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid p-4">
            @yield('content')
        </div>
        
        <!-- Footer -->
        <footer class="mt-auto py-3 text-center text-muted small border-top border-secondary">
            &copy; {{ date('Y') }} Chirakama Importadora Automotriz. Todos los derechos reservados.
        </footer>
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js (Para gráficas en el dashboard) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- App Scripts -->
    <script src="{{ asset('assets/js/api.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>

    document.getElementById('logoutBtn')
        .addEventListener('click', async function(e) {

            e.preventDefault();

            const token = localStorage.getItem('token');

            try {

                await fetch('/api/logout', {

                    method: 'POST',

                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }

                });

            } catch(error) {

                console.error(error);

            }

            localStorage.removeItem('token');

            window.location.href = '/login';

        });

</script>
    @stack('scripts')
    <script>

    const token = localStorage.getItem('token');

    if(!token) {

        window.location.href = '/login';

    }

</script>
</body>
</html>
