@extends('layouts.app')

@section('title', 'Управление меню')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Управление меню</h1>
        <a href="{{ route('admin.dishes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить блюдо
        </a>
    </div>
    
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Фото</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Цена</th>
                        <th>Категория</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                            @if($item->image)
                                <img src="/uploads/menu/{{ $item->image }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                            @else
                                <span class="text-muted">Нет фото</span>
                            @endif
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->price }} ₽</td>
                        <td>{{ $item->category }}</td>
                        <td>
                            <a href="{{ route('admin.dishes.edit', $item->id) }}" class="btn btn-sm btn-warning">✏️</a>
                            <a href="{{ route('admin.dishes.delete', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Удалить блюдо?')">❌</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection