@extends('layouts.app')

@section('title', 'Редактирование блюда')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Редактировать блюдо</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.dishes.update', $item->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название</label>
                            <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3">{{ $item->description }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Цена</label>
                                <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Категория</label>
                                <select name="category" class="form-control">
                                    <option {{ $item->category == 'Горячее' ? 'selected' : '' }}>Горячее</option>
                                    <option {{ $item->category == 'Супы' ? 'selected' : '' }}>Супы</option>
                                    <option {{ $item->category == 'Салаты' ? 'selected' : '' }}>Салаты</option>
                                    <option {{ $item->category == 'Закуски' ? 'selected' : '' }}>Закуски</option>
                                    <option {{ $item->category == 'Десерты' ? 'selected' : '' }}>Десерты</option>
                                    <option {{ $item->category == 'Напитки' ? 'selected' : '' }}>Напитки</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Текущее фото</label><br>
                            @if($item->image)
                                <img src="/uploads/menu/{{ $item->image }}" style="max-width: 200px; max-height: 150px; margin-bottom: 10px; border: 1px solid #ddd;">
                            @else
                                <p class="text-muted">Нет фото</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Заменить фото</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Оставьте пустым, если не хотите менять фото</small>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection