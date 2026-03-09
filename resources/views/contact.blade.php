@extends('layouts.app')

@section('title', 'Контакты')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5">Контакты</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="mb-4">Как нас найти</h3>
                <p><strong>📍 Адрес:</strong> г. Москва, ул. Тверская, 15</p>
                <p><strong>📞 Телефон:</strong> +7 (999) 123-45-67</p>
                <p><strong>📧 Email:</strong> info@vkusny.ru</p>
                <p><strong>🕒 Часы работы:</strong> 12:00 - 23:00 ежедневно</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="mb-4">Схема проезда</h3>
                <p>Мы находимся в центре города, рядом с метро Тверская.</p>
                <p>От метро 5 минут пешком.</p>
            </div>
        </div>
    </div>
</div>
@endsection