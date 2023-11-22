@extends('layouts.base')

@section('title', 'Редактирование статьи')

@section('content')
<section class="section-edit section">
    <div class="wrapper">
        <h2 class="section__header">Редактирование статьи</h2>
        <form  class="article-form" action="{{ route('articles.update', $article)}}" method="post">
            @csrf
            @method('put')
            <label class="article-form__label" for="title">Заголовок</label>
            <input class="article-form__input" type="text" name="title" value="{{ $article -> title }}">
            @error('title')
            <p class="error" >{{ $message }}</p>
            @enderror
            <label class="article-form__label" for="desc">Текст</label>
            <textarea class="article-form__textarea" type="text" name="desc" maxlength="400">{{ $article -> desc }}</textarea>
            @error('desc')
            <p class="error">{{ $message }}</p>
            @enderror
            <button class="article-form__submit-button" type="submit">Сохранить</button>
        </form>
    </div>
</section>
@endsection
