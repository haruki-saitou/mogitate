<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>mogitate</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    @yield('css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">

</head>
<header class="header">
    <div class="header__inner">
        <h1 class="header__title"><a href="{{ route('products.index') }}" class="header__title__logo">mogitate</a></h1>
    </div>
</header>

<body>
    <main>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>
    @yield('script')
</body>

</html>
