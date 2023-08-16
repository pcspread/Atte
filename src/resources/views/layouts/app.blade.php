<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="This application is 'Atte' that manages attendance." />
    <title>Atte</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}" />
    @yield('css')
    
    <script src="{{ asset('js/layouts/app.js') }}" defer></script>
    @yield('js')
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="header-title">
                <a class="header-title__link" href="">Atte</a>
            </div>

            @if (Auth::check())
            <div class="header-nav">
                <nav class="nav-content">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a class="nav-link" href="/">
                                ホーム
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/attendance/list">
                                社員一覧
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/attendance">
                                日付一覧
                            </a>
                        </li>
                        <li class="nav-item">
                            <form class="nav-item__logout-form" action="/logout" method="POST">
                            @csrf
                                <input class="nav-item__input-hidden" type="hidden" name="id" value="{{ session('id') ?? '' }}">
                                <button class="nav-link__button">ログアウト</button>
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="burger">
                <div class="burger-line"></div>
                <div class="burger-line"></div>
                <div class="burger-line"></div>
            </div>
            @endif
        </header>

        <main class="main">
            @yield('content')
        </main>

        <div class="upper">
            <a class="upper-link" href="#"><</a>
        </div>

        <footer class="footer">
            <small class="footer-content">
                Atte, inc.
            </small>
        </footer>
    </div>
</body>
</html>