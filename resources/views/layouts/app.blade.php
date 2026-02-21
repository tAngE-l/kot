<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ресторан - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar { background-color: #8B4513 !important; }
        .navbar-brand, .nav-link { color: white !important; }
        .nav-link:hover { color: #FFD700 !important; }
        footer { background-color: #333; color: white; padding: 20px 0; margin-top: 50px; }
        .card { margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .price { font-size: 1.3rem; color: #8B4513; font-weight: bold; }
        .hero { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1200'); background-size: cover; color: white; padding: 100px 0; text-align: center; }
        .alert { margin-top: 20px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">🍽️ Вкусный Уголок</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Главная</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Меню</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">О нас</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Контакты</a></li>
                    
                    @if(session('user_id'))
                        <li class="nav-item">
                            <span class="nav-link">👤 {{ session('username') }}</span>
                        </li>
                        @if(session('is_admin'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin') }}">Админка</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Выйти</a>
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

    <main>
        @if(session('success'))
            <div class="container mt-3">
                <div class="alert alert-success">{{ session('success') }}</div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="container mt-3">
                <div class="alert alert-danger">{{ session('error') }}</div>
            </div>
        @endif
        
        @yield('content')
    </main>

    <footer>
        <div class="container text-center">
            <p>© 2026 Ресторан "Вкусный Уголок". Все права защищены.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>