@extends('layouts.base')

@section('title', 'Главная')

@section('content')
    <div class="wrapper">
        <div class="hello-section section">
            <h1 class="hello-section__title section__title">Добро пожаловать на наш сайт!</h1>
            <p class="hello-section__text section__text ">Обман! Это не про нас.</p>
        </div>
    </div>  
    @if (!empty($data))
    <section class="articles-section section">
    @foreach ($data as $item)
                <div class="wrapper">
                    <div class="article">
                        <a href="{{ route('gallery') }}" class="article__link"><img src="{{ asset('images/' . $item['preview_image']) }}" alt="Картинка-превью" class="article__image"></a>
                        <div class="article__card">
                            <h2 class="article__title">{{$item['name']}}</h2>
                            <p class="article__desc">{{$item['desc']}}</p>
                            <p class="article__date">{{$item['date']}}</p>
                        </div>
                    </div>
                </div>
    @endforeach
    </section>
    @endif

@endsection