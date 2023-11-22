@extends ('layouts.base')

@section('title', 'Галлерея')

@section('content') 

    <section class="section">
        <div class="wrapper">
            <h2 class="section__title">Галлерея</h2>
            <div class="gallery">
            @foreach ($data as $item)
                <div class="gallery__item">
                    <img src="{{ asset('images/' . $item['full_image']) }}" alt="Картинка в галлерее" class="gallery__image">
                    <h3 class="gallery__image-article">{{ $item['name'] }}</h3>
                </div>
            @endforeach
            </div>
        </div>
    </section>

@endsection