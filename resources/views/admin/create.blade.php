@extends('layouts.app')

@section('title', 'Добавление блюда')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Добавить новое блюдо</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Название блюда</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание</label>
                            <textarea name="description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Цена (руб)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Категория</label>
                            <select name="category" class="form-control" required>
                                <option value="Горячее">Горячее</option>
                                <option value="Супы">Супы</option>
                                <option value="Салаты">Салаты</option>
                                <option value="Закуски">Закуски</option>
                                <option value="Паста">Паста</option>
                                <option value="Десерты">Десерты</option>
                                <option value="Напитки">Напитки</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Сохранить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection