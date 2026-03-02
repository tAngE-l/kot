<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Ресторан - @yield('title')</title>
    
    <!-- Bootstrap & Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* ===== ОСНОВНЫЕ НАСТРОЙКИ ===== */
        body {
            font-family: 'Inter', sans-serif;
            padding-top: 70px;
            background: #fff;
            color: #1e293b;
        }
        
        /* ===== НАВИГАЦИЯ ===== */
        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 600;
            font-size: 1.4rem;
            color: #0f172a !important;
        }
        
        .navbar-brand i {
            color: #e67e22;
            margin-right: 6px;
        }
        
        .navbar-nav .nav-link {
            color: #475569 !important;
            font-weight: 500;
            margin: 0 0.8rem;
            padding: 0.5rem 0;
            border-bottom: 2px solid transparent;
        }
        
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #e67e22 !important;
            border-bottom-color: #e67e22;
        }
        
        /* ===== КНОПКИ ===== */
        .btn {
            font-weight: 500;
            padding: 0.5rem 1.2rem;
            border-radius: 6px;
        }
        
        .btn-primary {
            background: #e67e22;
            border: none;
        }
        
        .btn-primary:hover {
            background: #d35400;
        }
        
        .btn-outline-primary {
            border: 1.5px solid #e67e22;
            color: #e67e22;
        }
        
        .btn-outline-primary:hover {
            background: #e67e22;
            color: #fff;
        }
        
        /* ===== КАРТОЧКИ ===== */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.02);
            transition: 0.2s;
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.05);
        }
        
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        
        /* ===== ГЕРОЙ ===== */
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.2)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1400');
            background-size: cover;
            background-position: center;
            min-height: 500px;
            display: flex;
            align-items: center;
            color: white;
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
        }
        
        /* ===== ФУТЕР ===== */
        footer {
            background: #1e293b;
            color: white;
            padding: 40px 0 20px;
            margin-top: 50px;
        }
        
        footer h5 {
            color: #e67e22;
            margin-bottom: 20px;
        }
        
        footer a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
        }
        
        footer a:hover {
            opacity: 1;
            color: #e67e22;
        }
        
        /* ===== АДАПТАЦИЯ ===== */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- ===== НАВИГАЦИЯ ===== -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-utensils"></i> Ресторан
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">Меню</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reservation.create') ? 'active' : '' }}" href="{{ route('reservation.create') }}">Бронь</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Контакты</a>
                    </li>
                    
                    @if(session('user_id'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ session('username') }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Профиль</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.reservations') }}">Мои брони</a></li>
                            @if(session('is_admin') == 1)
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('admin') }}">Админка</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout">Выйти</a></li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- ===== УВЕДОМЛЕНИЯ ===== -->
    <div class="container mt-3">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
    </div>

    <!-- ===== КОНТЕНТ ===== -->
    <main>
        @yield('content')
    </main>

    <!-- ===== ФУТЕР ===== -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Ресторан</h5>
                    <p class="opacity-75">ул. Тверская, 15<br> +7 (999) 123-45-67</p>
                </div>
                <div class="col-md-4">
                    <h5>Часы</h5>
                    <p class="opacity-75">12:00 - 23:00 ежедневно</p>
                </div>
                <div class="col-md-4">
                    <h5>Соцсети</h5>
                    <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="me-3"><i class="fab fa-telegram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <hr class="opacity-25">
            <div class="text-center opacity-75">
                <p>&copy; {{ date('Y') }} Ресторан. Все права защищены.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>