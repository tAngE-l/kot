@extends('layouts.app')

@section('title', 'Меню')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">Наше меню</h1>
    
    @foreach($menu as $category => $items)
    <div class="mb-5">
        <h2 class="text-center mb-4" style="color: #8B4513;">{{ $category }}</h2>
        <div class="row">
            @foreach($items as $item)
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=200" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;" alt="Блюдо">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text">{{ $item->description }}</p>
                                <p class="price">{{ $item->price }} ₽</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection