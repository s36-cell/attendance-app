<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>COACHTECH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>

<header class="header">

    <div class="header-logo">
        <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
    </div>

    <nav class="header-nav">
        <a href="{{ route('attendance.index') }}">勤怠</a>
        <a href="{{ route('attendance.list') }}">勤怠一覧</a>
        <a href="{{ route('attendance.requests') }}">申請</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">ログアウト</button>
        </form>
    </nav>

</header>

<main>
    @yield('content')
</main>

</body>
</html>