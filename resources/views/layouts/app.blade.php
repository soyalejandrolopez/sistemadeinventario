<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #eaefff;
            --secondary: #38c172;
            --secondary-dark: #1f9d55;
            --secondary-light: #e3f5eb;
            --dark: #2d3748;
            --light: #f8fafc;
            --gray: #a0aec0;
            --gray-light: #f1f5f9;
            --gray-dark: #64748b;
            --danger: #e3342f;
            --danger-light: #fee2e2;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --info: #3498db;
            --info-light: #e0f2fe;
            --success: #38c172;
            --success-light: #dcfce7;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: var(--dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        #app {
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1 0 auto;
        }
        
        /* Navbar Styles */
        .navbar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #4361ee, #3a56d4);
            padding: 0.8rem 1rem;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            color: white !important;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand i {
            margin-right: 0.5rem;
            font-size: 1.2rem;
        }
        
        .navbar-light .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.7rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .navbar-light .navbar-nav .nav-link i {
            margin-right: 0.5rem;
            font-size: 1rem;
        }
        
        .navbar-light .navbar-nav .nav-link:hover {
            color: white !important;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .navbar-light .navbar-nav .nav-link.active {
            color: white !important;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-toggler {
            border: none;
            padding: 0.4rem;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }
        
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }
        
        .navbar-light .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 0.5rem;
            min-width: 14rem;
            margin-top: 0.5rem;
            animation: fadeIn 0.2s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-item {
            padding: 0.7rem 1.5rem;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
        }
        
        .dropdown-item:hover {
            background-color: var(--primary-light);
            color: var(--primary);
            transform: translateX(3px);
        }
        
        @media (max-width: 767.98px) {
            .navbar-collapse {
                background: rgba(67, 97, 238, 0.98);
                border-radius: 0.5rem;
                padding: 1rem;
                margin-top: 1rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                max-height: 80vh;
                overflow-y: auto;
            }
            
            .navbar-nav {
                padding: 0.5rem;
            }
            
            .navbar-light .navbar-nav .nav-link {
                margin-bottom: 0.5rem;
                border-radius: 6px;
            }
            
            .navbar-light .navbar-nav .nav-link.active {
                background: rgba(255, 255, 255, 0.2);
            }
            
            .navbar-nav.ml-auto {
                margin-top: 1rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding-top: 1rem;
            }
        }
        
        /* Bootstrap 4 margin utilities */
        .mr-1 {
            margin-right: 0.25rem !important;
        }
        .mr-2 {
            margin-right: 0.5rem !important;
        }
        .mr-3 {
            margin-right: 1rem !important;
        }
        .ml-1 {
            margin-left: 0.25rem !important;
        }
        .ml-2 {
            margin-left: 0.5rem !important;
        }
        .ml-3 {
            margin-left: 1rem !important;
        }
        
        /* Contenido principal */
        .py-4 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 600;
            padding: 15px 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        /* Button Styles */
        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        
        /* Table Styles */
        .table {
            color: var(--dark);
        }
        
        .table thead th {
            border-top: none;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .table td {
            vertical-align: middle;
            border-color: #e2e8f0;
        }
        
        /* Pagination */
        .pagination {
            margin-bottom: 0;
        }
        
        .page-link {
            color: var(--primary);
            border: none;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        /* Alert Styles */
        .alert {
            border: none;
            border-radius: 10px;
        }
        
        .alert-success {
            background-color: rgba(56, 193, 114, 0.1);
            color: var(--secondary-dark);
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #e53e3e;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-box-open"></i>
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('productos.*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                                    <i class="fas fa-cubes mr-1"></i> Productos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">
                                    <i class="fas fa-tags mr-1"></i> Categorías
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('proveedores.*') ? 'active' : '' }}" href="{{ route('proveedores.index') }}">
                                    <i class="fas fa-truck mr-1"></i> Proveedores
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::routeIs('ordenes.*') ? 'active' : '' }}" href="{{ route('ordenes.index') }}">
                                    <i class="fas fa-shopping-cart mr-1"></i> Órdenes
                                </a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="fas fa-sign-in-alt mr-1"></i> {{ __('Login') }}
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus mr-1"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle mr-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt mr-1"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>

        <footer>
            <div class="container text-center">
                <p>© {{ date('Y') }} Sistema de Inventario SENA. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    
    @yield('scripts')
</body>
</html>
