@extends('layouts.app')

@section('title', 'Главная')

@section('content')
<div class="hero-section" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=1400'); background-size: cover; background-position: center; min-height: 500px; display: flex; align-items: center;">
    <div class="container text-center text-white">
        <h1 style="font-size: 3.5rem; font-weight: 700;">Добро пожаловать</h1>
        <p class="lead">Ресторан с уютной атмосферой и вкусной едой</p>
        <a href="{{ route('menu') }}" class="btn btn-primary btn-lg mt-3">Посмотреть меню</a>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Популярные блюда</h2>
    <div class="row">
        @foreach($recommended as $item)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($item->image)
                    <img src="/uploads/menu/{{ $item->image }}" class="card-img-top" alt="{{ $item->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <img src="https://via.placeholder.com/300x200?text=Ресторан" class="card-img-top" alt="Ресторан" style="height: 200px; object-fit: cover;">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <p class="card-text">{{ $item->description }}</p>
                    <p class="fw-bold text-primary">{{ $item->price }} ₽</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection