@extends('layouts.app')

@section('title', 'Меню')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">Наше меню</h1>
    
    @foreach($menu as $category => $items)
    <h2 class="mb-4">{{ $category }}</h2>
    <div class="row mb-5">
        @foreach($items as $item)
        <div class="col-md-4 mb-4">
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
    @endforeach
</div>
@endsection