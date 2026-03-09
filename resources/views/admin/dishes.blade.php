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
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
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
                        <td>{{ Str::limit($item->description, 50) }}</td>
                        <td>{{ $item->price }} ₽</td>
                        <td>{{ $item->category }}</td>
                        <td>
                            <a href="{{ route('admin.dishes.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Редактировать">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <form method="POST" action="{{ route('admin.dishes.delete', $item->id) }}" style="display: inline;" onsubmit="return confirm('Вы уверены, что хотите удалить блюдо "{{ $item->name }}"?')">
                                @csrf
                                <input type="hidden" name="token" value="{{ md5($item->id . session('user_id') . config('app.key')) }}">
                                <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection