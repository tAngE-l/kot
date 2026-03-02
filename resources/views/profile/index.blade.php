@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-5" style="color: #8B4513;">Личный кабинет</h1>
    
    <div class="row">
       
        <div class="col-md-4 mb-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%) !important;">
                    <h4 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>{{ $user->username }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-5x" style="color: #8B4513;"></i>
                    </div>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-envelope me-2 text-warning"></i>Email:</span>
                            <span class="fw-bold">{{ $user->email }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-calendar-check me-2 text-warning"></i>Броней:</span>
                            <span class="fw-bold">{{ count($reservations) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><i class="fas fa-user-tag me-2 text-warning"></i>Статус:</span>
                            @if($user->is_admin)
                                <span class="badge bg-danger">Администратор</span>
                            @else
                                <span class="badge bg-success">Клиент</span>
                            @endif
                        </li>
                    </ul>
                    
                    <button class="btn btn-outline-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-2"></i>Редактировать профиль
                    </button>
                </div>
            </div>
        </div>
        
  
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white py-3" style="background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-alt me-2"></i>Мои бронирования
                    </h4>
                </div>
                <div class="card-body">
                    @if(count($reservations) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
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
    </div>
</div>


<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%);">
                <h5 class="modal-title text-white">
                    <i class="fas fa-edit me-2"></i>Редактировать профиль
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Логин</label>
                        <input type="text" class="form-control" value="{{ $user->username }}" disabled>
                        <small class="text-muted">Логин изменить нельзя</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Новый пароль</label>
                        <input type="password" name="password" class="form-control" placeholder="Оставьте пустым, если не хотите менять">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection