@extends('layouts.app')

@section('title', 'Редактирование блюда')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Редактировать блюдо</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.update', $item->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название блюда</label>
                            <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3" required>{{ $item->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Цена (руб)</label>
                            <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category" class="form-control" required>
                                <option value="Горячее" {{ $item->category == 'Горячее' ? 'selected' : '' }}>Горячее</option>
                                <option value="Супы" {{ $item->category == 'Супы' ? 'selected' : '' }}>Супы</option>
                                <option value="Салаты" {{ $item->category == 'Салаты' ? 'selected' : '' }}>Салаты</option>
                                <option value="Закуски" {{ $item->category == 'Закуски' ? 'selected' : '' }}>Закуски</option>
                                <option value="Паста" {{ $item->category == 'Паста' ? 'selected' : '' }}>Паста</option>
                                <option value="Десерты" {{ $item->category == 'Десерты' ? 'selected' : '' }}>Десерты</option>
                                <option value="Напитки" {{ $item->category == 'Напитки' ? 'selected' : '' }}>Напитки</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Обновить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection