@extends('layouts.base')

@section('title', 'Редактироваие комментария')

@section('content')
<div class="comment-editing">
    <form action="{{ route('comments.update', $comment) }}" method="post">
        @csrf
        @method('put')
        <input type="text" name="desc" required value="{{$comment-> desc}}">
        <button type="submit">Сохранить</button>
    </form>
</div>
@endsection