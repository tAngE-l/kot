@extends('layouts.app')

@section('title', 'Управление бронями')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Управление бронированиями</h1>
        <a href="{{ route('admin.dishes') }}" class="btn btn-primary">📋 К блюдам</a>
    </div>
    
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Список всех броней</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Дата</th>
                            <th>Время</th>
                            <th>Гостей</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $r)
                        <tr>
                            <td>{{ $r->id }}</td>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->phone }}</td>
                            <td>{{ $r->email }}</td>
                            <td>{{ date('d.m.Y', strtotime($r->date)) }}</td>
                            <td>{{ $r->time }}</td>
                            <td>{{ $r->guests }}</td>
                            <td>
                                @if($r->status == 'pending')
                                    <span class="badge bg-warning">Ожидает</span>
                                @elseif($r->status == 'confirmed')
                                    <span class="badge bg-success">Подтверждено</span>
                                @elseif($r->status == 'cancelled')
                                    <span class="badge bg-danger">Отменено</span>
                                @else
                                    <span class="badge bg-secondary">{{ $r->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations.edit', $r->id) }}" class="btn btn-warning btn-sm">✏️ Ред.</a>
                                <a href="{{ route('admin.reservations.delete', $r->id) }}" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Удалить бронь?')">❌ Уд.</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection