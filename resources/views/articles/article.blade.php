@extends('layouts.base')

@section('title', 'Редактироваие статьи')

@section('content')

<div class="article">
    <div class="article__text">
        <h3 class="article__header">{{ $article->title }}</h3>
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
    <form class="article__comment-form" action="{{ route('comments.store', $article) }}" method="post">
            @csrf
            @method('post')
            <label for="#comment-textarea" hidden>Оставить комментарий</label>
            <textarea placeholder="Оставьте комментарий" class="article__comment-textarea" name="comment" id="comment-textarea" class="article__comment-input" maxlength="200"></textarea>
            <button type="submit" class="article__comment-submit">Комментировать</button>
        </form>
        <div class="article__comments-list">
            <h4 class="article__comments-titile">Комментарии</h4>
            @foreach ($article -> comments as $comment)
                <div class="article__comment comment">
                    <p class="comment__content">{{ $comment -> desc}}</p>
                    <a class="comment__edit-link edit-link" href="{{ route('comments.edit', $comment, $article)}}" >
                        @csrf
                        <p>Редактировать</p>
                    </a>
                </div>
            @endforeach
        </div>
</div>
@endsection