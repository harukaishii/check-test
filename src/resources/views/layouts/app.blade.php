<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fashionably Late</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-utilities">
        <a class="header__logo" href="/"> Fashionably Late</a>
        <nav>
          <ul class="header-nav">
            {{-- ログインページの場合 --}}
            @if(Request::is('login'))
                <li class="header-nav__item">
                    <a href="/register" class="header-nav__button">register</a>
                </li>
            {{-- 登録ページの場合 --}}
            @elseif(Request::is('register'))
                <li class="header-nav__item">
                    <a href="/login" class="header-nav__button">login</a>
                </li>
            {{-- 管理ページの場合 (認証済みの場合のみlogoutボタンを表示) --}}
            @elseif(Request::is('admin*')) {{-- /admin または /admin/users などの下層ページにも対応 --}}
                @if (Auth::check())
                <li class="header-nav__item">
                    <form class="logout-form" action="/logout" method="POST">
                    @csrf
                        <button type="submit" class="header-nav__button">logout</button>
                    </form>
                </li>
                @endif
            @endif
          </ul>
        </nav>
        </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>
