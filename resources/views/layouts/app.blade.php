<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FashionablyLate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @yield('css')
</head>

<body>
    <header class="header">
        <h1 class="logo">FashionablyLate</h1>
        <nav>
            <a href="{{ url('/register') }}" class="header__link">register</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>