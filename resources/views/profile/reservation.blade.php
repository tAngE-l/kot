@extends('layouts.app')

@section('title', 'Мои брони')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Мои бронирования</h1>
        <a href="{{ route('reservation.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Новая бронь
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
            @if($reservations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
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
                                <td>{{ date('d.m.Y', strtotime($r->date)) }}</td>
                                <td>{{ $r->time }}</td>
                                <td>{{ $r->guests }}</td>
                                <td>
                                    @if($r->status == 'pending')
                                        <span class="badge bg-warning text-dark">Ожидает подтверждения</span>
                                    @elseif($r->status == 'confirmed')
                                        <span class="badge bg-success">Подтверждено</span>
                                    @elseif($r->status == 'cancelled')
                                        <span class="badge bg-danger">Отменено</span>
                                    @endif
                                </td>
                                <td>
                                    @if($r->status == 'pending')
                                        <form method="POST" action="{{ route('profile.reservation.cancel', $r->id) }}" style="display: inline;" onsubmit="return confirm('Отменить бронь?')">
                                            @csrf
                                            <input type="hidden" name="token" value="{{ md5($r->id . session('user_id') . config('app.key')) }}">
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-times"></i> Отменить
                                            </button>
                                        </form>
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