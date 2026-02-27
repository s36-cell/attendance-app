<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<header class="auth-header">
    <img src="{{ asset('images/logo.png') }}" alt="COACHTECHロゴ">
</header>

<main class="auth-container">
    <h1 class="auth-title">ログイン</h1>

    @if ($errors->any())
        <div class="form-errors">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email">
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password">
        </div>

        <button type="submit" class="auth-button">ログインする</button>

        <div class="auth-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </div>
    </form>
</main>

</body>
</html>