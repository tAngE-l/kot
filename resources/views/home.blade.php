@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="hero">
    <div class="container">
        <h1 class="display-3">Добро пожаловать!</h1>
        <p class="lead">Ресторан "Вкусный Уголок" - уютное место для всей семьи</p>
        <a href="{{ route('menu') }}" class="btn btn-warning btn-lg mt-3">Посмотреть меню</a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Наши популярные блюда</h2>
    <div class="row">
        @foreach($recommended as $item)
        <div class="col-md-3">
            <div class="card">
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=300" class="card-img-top" alt="Блюдо">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <p class="price">{{ $item->price }} ₽</p>
                    <span class="badge bg-warning">{{ $item->category }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection