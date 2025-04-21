<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Sistema de Inventario') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
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
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            html {
                scroll-behavior: smooth;
            }
            
            body {
                font-family: 'Poppins', sans-serif;
                color: var(--dark);
                background-color: var(--light);
                line-height: 1.6;
            }
            
            .hero {
                background: linear-gradient(135deg, #4361ee, #3a56d4);
                color: white;
                padding: 6rem 0;
                position: relative;
                overflow: hidden;
            }
            
            .hero::before {
                content: '';
                position: absolute;
                top: -5%;
                right: -5%;
                width: 50%;
                height: 50%;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                pointer-events: none;
            }
            
            .hero::after {
                content: '';
                position: absolute;
                bottom: -10%;
                left: -10%;
                width: 70%;
                height: 70%;
                background: rgba(255, 255, 255, 0.05);
                border-radius: 50%;
                pointer-events: none;
            }
            
            .hero h1 {
                font-size: 3rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
            }
            
            .hero p {
                font-size: 1.2rem;
                font-weight: 300;
                margin-bottom: 2rem;
                max-width: 600px;
            }
            
            .hero-btn {
                display: inline-block;
                padding: 0.8rem 2rem;
                background-color: white;
                color: var(--primary);
                font-weight: 600;
                border-radius: 4px;
                transition: all 0.3s ease;
                text-decoration: none;
                margin-right: 1rem;
                border: 2px solid white;
            }
            
            .hero-btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                text-decoration: none;
                color: var(--primary-dark);
            }
            
            .hero-btn.outline {
                background-color: transparent;
                color: white;
            }
            
            .hero-btn.outline:hover {
                background-color: white;
                color: var(--primary);
            }
            
            .nav-link {
                color: rgba(255, 255, 255, 0.85);
                font-weight: 500;
                padding: 0.5rem 1rem;
                transition: all 0.3s ease;
            }
            
            .nav-link:hover {
                color: white;
            }
            
            .features {
                padding: 6rem 0;
                background-color: white;
            }
            
            .section-title {
                text-align: center;
                margin-bottom: 4rem;
            }
            
            .section-title h2 {
                font-size: 2.5rem;
                font-weight: 700;
                color: var(--primary);
                position: relative;
                display: inline-block;
                margin-bottom: 1rem;
            }
            
            .section-title h2::after {
                content: '';
                position: absolute;
                width: 80px;
                height: 4px;
                background: var(--primary);
                bottom: -0.5rem;
                left: 50%;
                transform: translateX(-50%);
                border-radius: 2px;
            }
            
            .section-title p {
                font-size: 1.1rem;
                color: var(--gray-dark);
                max-width: 700px;
                margin: 0 auto;
            }
            
            .feature-card {
                text-align: center;
                padding: 2rem;
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                height: 100%;
                background-color: white;
            }
            
            .feature-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            }
            
            .feature-icon {
                width: 80px;
                height: 80px;
                margin: 0 auto 1.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background-color: var(--primary-light);
                color: var(--primary);
                font-size: 2rem;
            }
            
            .feature-card h3 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: var(--dark);
            }
            
            .feature-card p {
                color: var(--gray-dark);
                font-size: 1rem;
            }
            
            .screenshot-section {
                padding: 6rem 0;
                background-color: var(--gray-light);
                position: relative;
            }
            
            .screenshot-img {
                box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .screenshot-img img {
                width: 100%;
                height: auto;
                border-radius: 8px;
                transition: all 0.3s ease;
            }
            
            .screenshot-img:hover img {
                transform: scale(1.02);
            }
            
            .cta-section {
                padding: 5rem 0;
                background: linear-gradient(135deg, #38c172, #1f9d55);
                color: white;
                text-align: center;
            }
            
            .cta-section h2 {
                font-size: 2.5rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
            }
            
            .cta-section p {
                font-size: 1.2rem;
                margin-bottom: 2rem;
                max-width: 700px;
                margin-left: auto;
                margin-right: auto;
            }
            
            .navbar-landing {
                padding: 1rem 0;
                transition: all 0.3s ease;
            }
            
            .navbar-landing.scrolled {
                background: var(--primary);
                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
                padding: 0.5rem 0;
            }
            
            footer {
                background-color: var(--dark);
                color: white;
                padding: 4rem 0 2rem;
            }
            
            .footer-title {
                font-size: 1.5rem;
                font-weight: 600;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
            }
            
            .footer-title i {
                margin-right: 0.5rem;
            }
            
            .footer-links {
                list-style: none;
                padding: 0;
            }
            
            .footer-links li {
                margin-bottom: 0.8rem;
            }
            
            .footer-links a {
                color: rgba(255, 255, 255, 0.7);
                transition: all 0.3s ease;
                text-decoration: none;
            }
            
            .footer-links a:hover {
                color: white;
                padding-left: 5px;
            }
            
            .copyright {
                margin-top: 3rem;
                padding-top: 2rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                text-align: center;
                color: rgba(255, 255, 255, 0.7);
                font-size: 0.9rem;
            }
            
            .social-links {
                display: flex;
                margin-top: 1.5rem;
            }
            
            .social-links a {
                width: 38px;
                height: 38px;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: rgba(255, 255, 255, 0.1);
                border-radius: 50%;
                margin-right: 1rem;
                color: white;
                transition: all 0.3s ease;
            }
            
            .social-links a:hover {
                background-color: var(--primary);
                transform: translateY(-3px);
            }
            
            @media (max-width: 767.98px) {
                .hero h1 {
                    font-size: 2.5rem;
                }
                
                .hero p {
                    font-size: 1rem;
                }
                
                .feature-card {
                    margin-bottom: 2rem;
                }
                
                .section-title h2 {
                    font-size: 2rem;
                }
            }
        </style>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-landing">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <i class="fas fa-box-open mr-2"></i>
                        {{ config('app.name', 'Sistema de Inventario') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#features">Características</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#screenshots">Capturas</a>
                            </li>
                            @if (Route::has('login'))
                                @auth
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('/home') }}">Dashboard</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                                    </li>
                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                                        </li>
                                    @endif
                                @endauth
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <section class="hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1>Sistema de Gestión de Inventario</h1>
                        <p>Una solución completa y moderna para administrar eficientemente tu inventario, proveedores y órdenes de compra en un solo lugar.</p>
                        <div class="hero-buttons">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/home') }}" class="hero-btn">Ir al Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="hero-btn">Iniciar sesión</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="hero-btn outline">Registrarse</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <img src="https://img.freepik.com/free-vector/warehouse-management-abstract-concept-vector-illustration_11668461.jpg" alt="Inventario Dashboard" class="img-fluid rounded shadow">
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="features">
            <div class="container">
                <div class="section-title">
                    <h2>Características Principales</h2>
                    <p>Nuestro sistema de inventario ofrece todas las herramientas que necesitas para gestionar eficientemente tu negocio</p>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-cubes"></i>
                            </div>
                            <h3>Gestión de Productos</h3>
                            <p>Administra tu catálogo de productos con información detallada, stock y precios actualizados.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h3>Categorías</h3>
                            <p>Organiza tus productos en categorías para facilitar la búsqueda y clasificación.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <h3>Proveedores</h3>
                            <p>Mantén un registro completo de tus proveedores con todos sus datos de contacto.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h3>Órdenes de Compra</h3>
                            <p>Crea y gestiona órdenes de compra para mantener tu inventario siempre actualizado.</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Dashboard</h3>
                            <p>Visualiza estadísticas importantes de tu negocio en tiempo real.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h3>Usuarios</h3>
                            <p>Control de acceso y roles para cada miembro de tu equipo.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h3>Diseño Responsive</h3>
                            <p>Accede al sistema desde cualquier dispositivo con una interfaz adaptable.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <h3>Seguridad</h3>
                            <p>Protección de datos y autenticación segura para toda la información.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="screenshots" class="screenshot-section">
            <div class="container">
                <div class="section-title">
                    <h2>Capturas de Pantalla</h2>
                    <p>Conoce la interfaz moderna y fácil de usar de nuestro sistema de gestión de inventario</p>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="screenshot-img">
                            <img src="https://img.freepik.com/free-vector/dashboard-user-panel-template_5261422.jpg" alt="Dashboard" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="screenshot-img">
                            <img src="https://img.freepik.com/free-photo/warehouse-worker-using-computer_11342710.jpg" alt="Productos" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="screenshot-img">
                            <img src="https://img.freepik.com/free-vector/purchase-order-concept-illustration_13416674.jpg" alt="Órdenes" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="container">
                <h2>¿Listo para comenzar?</h2>
                <p>Empieza a gestionar tu inventario de manera eficiente hoy mismo con nuestro sistema</p>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/home') }}" class="hero-btn">Ir al Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="hero-btn">Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="hero-btn outline">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </section>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h3 class="footer-title">
                            <i class="fas fa-box-open"></i> Sistema de Inventario
                        </h3>
                        <p>Una solución completa para la gestión de inventario, proveedores y órdenes de compra en un solo lugar.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h3 class="footer-title">Enlaces rápidos</h3>
                        <ul class="footer-links">
                            <li><a href="#features">Características</a></li>
                            <li><a href="#screenshots">Capturas</a></li>
                            @if (Route::has('login'))
                                @auth
                                    <li><a href="{{ url('/home') }}">Dashboard</a></li>
                                @else
                                    <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">Registrarse</a></li>
                                    @endif
                                @endauth
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h3 class="footer-title">Contacto</h3>
                        <ul class="footer-links">
                            <li><i class="fas fa-map-marker-alt mr-2"></i> Calle Principal #123, Ciudad</li>
                            <li><i class="fas fa-phone-alt mr-2"></i> +57 123 456 7890</li>
                            <li><i class="fas fa-envelope mr-2"></i> info@inventariosis.com</li>
                        </ul>
                    </div>
                </div>
                <div class="copyright">
                    <p>&copy; {{ date('Y') }} Sistema de Inventario. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
        <script>
            // Cambiar navbar al hacer scroll
            window.addEventListener('scroll', function() {
                const navbar = document.querySelector('.navbar-landing');
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            });
        </script>
    </body>
</html>
