@extends('layouts.base')

@section('title', 'Регистрация')

@section('content')
    <div class="auth-container">
        <h2 class="auth-title">Регистрация</h2>
        <a href="{{ route('login.form') }}" class="auth-subtitle">Войди</a>
        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <div class="auth-form__field">
                <label for="name" class="auth-form__label">Имя</label>
                <input id="name" type="text" name="name" required autofocus class="auth-form__input">
            </div>

            <div class="auth-form__field">
                <label for="email" class="auth-form__label">E-Mail</label>
                <input id="email" type="email" name="email" required class="auth-form__input">
            </div>

            <div class="auth-form__field">
                <label for="password" class="auth-form__label">Пароль</label>
                <input id="password" type="password" name="password" required class="auth-form__input">
            </div>

            <div class="auth-form__field">
                <label for="password-confirm" class="auth-form__label">Подтвердите пароль</label>
                <input id="password-confirm" type="password" name="password_confirmation" required class="auth-form__input">
            </div>

            <button type="submit" class="auth-form__button">Зарегистрироваться</button>
        </form>
    </div>
@endsection