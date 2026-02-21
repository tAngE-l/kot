@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Управление меню</h1>
        <a href="{{ route('admin.create') }}" class="btn btn-success">➕ Добавить блюдо</a>
    </div>
    
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
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
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->price }} ₽</td>
                <td>{{ $item->category }}</td>
                <td>
                    <a href="{{ route('admin.edit', $item->id) }}" class="btn btn-warning btn-sm">✏️ Ред.</a>
                    <a href="{{ route('admin.delete', $item->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Удалить?')">❌ Уд.</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection