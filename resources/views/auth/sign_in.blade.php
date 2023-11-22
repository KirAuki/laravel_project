@extends('layouts.base')

@section('title', 'Авторизация')


@section('content')
    <div class="auth-container">
        <h2 class="auth-title">Авторизация</h2>
        <a href="{{ route('register.form') }}" class="auth-subtitle">Регистрация</a>
        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="auth-form__field">
                <label for="email" class="auth-form__label">E-Mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="auth-form__input">
            </div>

            <div class="auth-form__field">
                <label for="password" class="auth-form__label">Пароль</label>
                <input id="password" type="password" name="password" required class="auth-form__input">
            </div>

            <div class="auth-form__field">
                <div class="auth-form__checkbox">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="auth-form__label">Запомнить меня</label>
                </div>
            </div>
            @error('error')
                <p class="auth-error">Неверные почта или пароль</p>
            @enderror
            <button type="submit" class="auth-form__button">Войти</button>
        </form>
    </div>
@endsection