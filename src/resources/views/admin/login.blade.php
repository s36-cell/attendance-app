@extends('layouts.app')

@section('content')

<div class="admin-login-wrapper">

<h1 class="admin-title">管理者ログイン</h1>

<form method="POST" action="{{ route('admin.login') }}">
@csrf

<div class="form-group">
<label>メールアドレス</label>
<input type="email" name="email">
</div>

<div class="form-group">
<label>パスワード</label>
<input type="password" name="password">
</div>

<button class="admin-login-button">
管理者ログインする
</button>

</form>

</div>

@endsection