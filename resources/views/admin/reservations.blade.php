@extends('layouts.app')

@section('title', 'Управление бронями')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Управление бронями</h1>
        <a href="{{ route('admin.dishes') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> К блюдам
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
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
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
                        @forelse($reservations as $r)
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
                                <a href="{{ route('admin.reservations.edit', $r->id) }}" class="btn btn-sm btn-warning" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form method="POST" action="{{ route('admin.reservations.delete', $r->id) }}" style="display: inline;" onsubmit="return confirm('Вы уверены, что хотите удалить бронь #{{ $r->id }}?')">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ md5($r->id . session('user_id') . config('app.key')) }}">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Удалить">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <p class="text-muted mb-0">Брони пока отсутствуют</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection