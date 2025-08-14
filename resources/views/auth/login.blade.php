@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="auth">
    <h2 class="auth__title">Login</h2>

    @if ($errors->any())
    <div class="errors">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="form" novalidate>
        @csrf

        <div class="form__group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email"
                value="{{ old('email') }}" required autocomplete="email" inputmode="email">
            @error('email') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <div class="form__group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password"
                required autocomplete="current-password" minlength="8">
            @error('password') <p class="form__error">{{ $message }}</p> @enderror
        </div>

        <button class="btn" type="submit">ログイン</button>

    </form>
</div>
@endsection