@extends('layouts.app')

@section('title', 'О нас')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">О нашем ресторане</h1>
    
    <div class="row">
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600" class="img-fluid rounded" alt="Интерьер">
        </div>
        <div class="col-md-6">
            <h2 class="mb-4">История</h2>
            <p>Ресторан "Вкусный Уголок" открылся в 2026 году. Мы создали уютное место, где каждый гость чувствует себя как дома.</p>
            <p>Наша команда - это профессионалы своего дела. Шеф-повар имеет 15-летний опыт работы в лучших ресторанах Москвы.</p>
            <p>Мы используем только свежие продукты и готовим с любовью для вас!</p>
        </div>
    </div>
</div>
@endsection