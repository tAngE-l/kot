@extends('layouts.app')

@section('title', 'Админ панель')

@section('content')
<div class="container my-5">
    <h1 class="mb-4">Админ панель</h1>
    
    <!-- Статистика -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Блюд</h5>
                    <p class="display-4">{{ $stats['dishes'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Броней всего</h5>
                    <p class="display-4">{{ $stats['reservations'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Ожидают</h5>
                    <p class="display-4">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Пользователей</h5>
                    <p class="display-4">{{ $stats['users'] }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Быстрые действия -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Быстрые действия</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.dishes.create') }}" class="btn btn-success me-2">➕ Добавить блюдо</a>
                    <a href="{{ route('admin.dishes') }}" class="btn btn-primary me-2">📋 Управление блюдами</a>
                    <a href="{{ route('admin.reservations') }}" class="btn btn-warning">📅 Управление бронями</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Последние брони -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Последние бронирования</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Имя</th>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Гостей</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentReservations as $r)
                            <tr>
                                <td>{{ $r->id }}</td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->date }}</td>
                                <td>{{ $r->time }}</td>
                                <td>{{ $r->guests }}</td>
                                <td>
                                    @if($r->status == 'pending')
                                        <span class="badge bg-warning">Ожидает</span>
                                    @elseif($r->status == 'confirmed')
                                        <span class="badge bg-success">Подтверждено</span>
                                    @elseif($r->status == 'cancelled')
                                        <span class="badge bg-danger">Отменено</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.reservations.edit', $r->id) }}" class="btn btn-sm btn-warning">Ред</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection