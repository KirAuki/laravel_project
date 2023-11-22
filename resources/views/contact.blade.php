@extends('layouts.base')

@section('title', 'Контакты')

@section('content')
    <h1>Контакты</h1>
    <p>Email: {{ $contactData['email'] }}</p>
    <p>Телефон: {{ $contactData['phone'] }}</p>
@endsection