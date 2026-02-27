<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員登録</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

<header class="auth-header">
    <img src="{{ asset('images/logo.png') }}" alt="COACHTECHロゴ">
</header>

<main class="auth-container">
    <h1 class="auth-title">会員登録</h1>

    @if ($errors->any())
        <div class="form-errors">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label>名前</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label>メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>パスワード</label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>パスワード確認</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit" class="auth-button">登録する</button>

        <div class="auth-link">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </div>
    </form>
</main>

</body>
</html>