@extends('layouts.app')

@section('title', 'Мои бронирования')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 style="color: #8B4513;">Мои бронирования</h1>
        <a href="{{ route('reservation.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>Новая бронь
        </a>
    </div>

    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white py-3" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%) !important;">
            <h4 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i>Список бронирований
            </h4>
        </div>
        <div class="card-body">
            @if(isset($reservations) && count($reservations) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Дата</th>
                                <th>Время</th>
                                <th>Гостей</th>
                                <th>Имя</th>
                                <th>Телефон</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $r)
                            <tr>
                                <td>{{ date('d.m.Y', strtotime($r->date)) }}</td>
                                <td>{{ $r->time }}</td>
                                <td>{{ $r->guests }}</td>
                                <td>{{ $r->name }}</td>
                                <td>{{ $r->phone }}</td>
                                <td>
                                    @if($r->status == 'pending')
                                        <span class="badge bg-warning text-dark">Ожидает</span>
                                    @elseif($r->status == 'confirmed')
                                        <span class="badge bg-success">Подтверждено</span>
                                    @elseif($r->status == 'cancelled')
                                        <span class="badge bg-danger">Отменено</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $r->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status == 'pending' || $r->status == 'confirmed')
                                        <a href="{{ route('profile.reservation.cancel', $r->id) }}" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Отменить бронь?')">
                                            <i class="fas fa-times"></i> Отменить
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">У вас пока нет бронирований</h5>
                    <a href="{{ route('reservation.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus-circle me-2"></i>Забронировать столик
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection