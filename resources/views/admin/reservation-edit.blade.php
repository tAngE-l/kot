@extends('layouts.app')

@section('title', 'Редактирование брони')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning">
                    <h4 class="mb-0">Редактировать бронь #{{ $reservation->id }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.reservations.update', $reservation->id) }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Имя</label>
                                <input type="text" class="form-control" value="{{ $reservation->name }}" disabled>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Телефон</label>
                                <input type="text" class="form-control" value="{{ $reservation->phone }}" disabled>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="{{ $reservation->email }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Статус</label>
                            <select name="status" class="form-control">
                                <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Ожидает</option>
                                <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>Подтверждено</option>
                                <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>Отменено</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Дата</label>
                                <input type="date" name="date" class="form-control" value="{{ $reservation->date }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Время</label>
                                <input type="time" name="time" class="form-control" value="{{ $reservation->time }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Гостей</label>
                                <input type="number" name="guests" class="form-control" value="{{ $reservation->guests }}" min="1" max="20" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Особые пожелания</label>
                            <textarea name="notes" class="form-control" rows="3">{{ $reservation->notes }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.reservations') }}" class="btn btn-secondary">Назад</a>
                            <button type="submit" class="btn btn-warning">Сохранить изменения</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection