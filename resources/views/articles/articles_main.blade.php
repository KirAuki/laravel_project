@extends('layouts.base')

@section('title', 'Статьи')

@section('content')
    <section class="article-section section">
            <h2 class="section__header">Статьи</h2>
            <form  class="article-form" action="{{ route('articles.store') }}" method="post">
                @csrf
                <label class="article-form__label" for="title">Заголовок</label>
                <input class="article-form__input" type="text" name="title">
                @error('title')
                <p class="error" >{{ $message }}</p>
                @enderror
                <label class="article-form__label" for="desc">Текст</label>
                <textarea class="article-form__textarea" type="text" name="desc" maxlength="400"></textarea>
                @error('desc')
                <p class="error">{{ $message }}</p>
                @enderror
                <button class="article-form__submit-button" type="submit">Опубликовать</button>
        </form>

        @foreach ($articles as $article)
        <a href="{{ route('articles.show', $article) }}" class="link-to-article">
            <div class="article">
                <div class="article__card">
                    <h3 class="article__title">{{ $article->title }}</h3>
                    <p class="article__desc">{{ $article->desc }}</p>
                    <form  method="post" action="{{ route('articles.destroy',  $article)}}">
                        @csrf
                        @method("delete")
                        <button class="article__delete-button" type="submit">X</button>
                    </form>
                    <a class="edit-link" href="{{ route('articles.edit',  $article)}}" >
                        @csrf
                        <p>Редактировать</p>
                    </a>
                </div>
            </div>
        </a>
        @endforeach

    </section>
    {{ $articles->links() }}
    
@endsection