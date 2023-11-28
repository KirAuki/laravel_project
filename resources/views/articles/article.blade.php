@extends('layouts.base')

@section('title', 'Редактироваие статьи')

@section('content')

<div class="article">
    <div class="article__text">
        <h3 class="article__header">{{ $article->title }}</h3>
        <p class="article__desc">{{ $article->desc }}</p>
        @can('update', $article)
        <form  method="post" action="{{ route('articles.destroy',  $article)}}">
            @csrf
            @method("delete")
            <button class="article__delete-button" type="submit">X</button>
        </form>
        <a class="edit-link" href="{{ route('articles.edit',  $article)}}" >
            @csrf
            <p>Редактировать</p>
        </a>
        @endcan
    </div>
    <form class="article__comment-form" action="{{ route('comments.store', $article) }}" method="post">
            @csrf
            @method('post')
            <label for="#comment-textarea" hidden>Оставить комментарий</label>
            <textarea placeholder="Оставьте комментарий" class="article__comment-textarea" required name="comment" id="comment-textarea" class="article__comment-input" maxlength="200"></textarea>
            <button type="submit" class="article__comment-submit">Комментировать</button>
        </form>
        <div class="article__comments-list">
            <h4 class="article__comments-titile">Комментарии</h4>
            @isset($_GET['res'])
            @if ($_GET['res'] == 1)
            <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                Комментарий успешно добавлен и отправлен на модерацию.
            </div>
            @endif
            @endisset
            @foreach ($article -> comments as $comment)
                
                @if($comment -> accept == 1)
                <div class="article__comment comment">
                    <p class="comment__content">{{ $comment -> desc}}</p>
                    @can('comment', $comment)
                    <a class="comment__edit-link edit-link" href="{{ route('comments.edit', $comment)}}" >
                        @csrf
                        <p>Редактировать</p>
                    </a>
                    <form  method="post" action="{{ route('comments.destroy',  $comment)}}">
                        @csrf
                        @method("delete")
                        <button class="comment__delete-button" type="submit">X</button>
                    </form>
                    @endcan
                </div>
                @endif
            @endforeach  
        </div>
</div>
@endsection