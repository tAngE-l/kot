@extends('layouts.app')

@section('title', 'Добавление блюда')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Добавить блюдо</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.dishes.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название блюда</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Цена (руб)</label>
                                <input type="number" name="price" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Категория</label>
                                <select name="category" class="form-control">
                                    <option>Горячее</option>
                                    <option>Супы</option>
                                    <option>Салаты</option>
                                    <option>Закуски</option>
                                    <option>Десерты</option>
                                    <option>Напитки</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Фото блюда</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                            <small class="text-muted">Любой формат будет сконвертирован в JFIF</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection