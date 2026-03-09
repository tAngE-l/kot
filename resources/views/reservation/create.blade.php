@extends('layouts.app')

@section('title', 'Бронирование столика')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-primary text-white py-3" style="background: linear-gradient(135deg, #8B4513 0%, #A0522D 100%) !important;">
                    <h3 class="mb-0 text-center">
                        <i class="fas fa-calendar-check me-2"></i>
                        Забронировать столик
                    </h3>
                </div>
                <div class="card-body p-4">
                    
                    <div class="text-center mb-4">
                        <div class="d-inline-block bg-light rounded-pill px-4 py-2">
                            <i class="fas fa-clock text-warning me-2"></i>
                            <span class="text-muted">Работаем ежедневно с 12:00 до 23:00</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('reservation.store') }}">
                        @csrf
                        
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2" style="color: #8B4513;">
                                    <i class="fas fa-user me-2"></i>Контактная информация
                                </h5>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Ваше имя <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-user text-warning"></i></span>
                                    <input type="text" name="name" class="form-control" value="{{ session('username') ?? '' }}" placeholder="Иван Иванов" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Телефон <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone text-warning"></i></span>
                                    <input type="tel" name="phone" class="form-control" placeholder="+7 (999) 123-45-67" required>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope text-warning"></i></span>
                                    <input type="email" name="email" class="form-control" placeholder="example@mail.ru" required>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2" style="color: #8B4513;">
                                    <i class="fas fa-clock me-2"></i>Детали бронирования
                                </h5>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Дата <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-calendar-alt text-warning"></i></span>
                                    <input type="date" name="date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Время <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-hourglass-half text-warning"></i></span>
                                    <input type="time" name="time" class="form-control" value="19:00" required>
                                </div>
                                <small class="text-muted">Работаем до 23:00</small>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Гостей <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-users text-warning"></i></span>
                                    <select name="guests" class="form-select" required>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ $i == 2 ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'гость' : ($i <= 4 ? 'гостя' : 'гостей') }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2" style="color: #8B4513;">
                                    <i class="fas fa-comment me-2"></i>Особые пожелания
                                </h5>
                            </div>
                            
                            <div class="col-12">
                                <textarea name="notes" class="form-control" rows="3" placeholder="Укажите особые пожелания, аллергии, праздничный повод..."></textarea>
                            </div>
                        </div>
                        
                        
                        <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                            <i class="fas fa-info-circle fa-2x me-3"></i>
                            <div>
                                <strong>Важно!</strong> После отправки заявки мы свяжемся с вами для подтверждения бронирования.
                            </div>
                        </div>
                        
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #8B4513; border-color: #8B4513;">
                                <i class="fas fa-check-circle me-2"></i>Забронировать
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg px-5">
                                <i class="fas fa-times-circle me-2"></i>Отмена
                            </a>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <small class="text-muted">
                        <i class="fas fa-phone-alt me-1"></i> По телефону: +7 (999) 123-45-67
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection