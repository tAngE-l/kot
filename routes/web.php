<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation.create');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/reservations', [ReservationController::class, 'userReservations'])->name('profile.reservations');
Route::post('/profile/reservation/cancel/{id}', [ReservationController::class, 'cancel'])->name('profile.reservation.cancel');

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    
    Route::get('/dishes', [AdminController::class, 'dishes'])->name('admin.dishes');
    Route::get('/dishes/create', [AdminController::class, 'createDish'])->name('admin.dishes.create');
    Route::post('/dishes/store', [AdminController::class, 'storeDish'])->name('admin.dishes.store');
    Route::get('/dishes/edit/{id}', [AdminController::class, 'editDish'])->name('admin.dishes.edit');
    Route::post('/dishes/update/{id}', [AdminController::class, 'updateDish'])->name('admin.dishes.update');
    Route::post('/dishes/delete/{id}', [AdminController::class, 'deleteDish'])->name('admin.dishes.delete');
    
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('admin.reservations');
    Route::get('/reservations/edit/{id}', [AdminController::class, 'editReservation'])->name('admin.reservations.edit');
    Route::post('/reservations/update/{id}', [AdminController::class, 'updateReservation'])->name('admin.reservations.update');
    Route::post('/reservations/delete/{id}', [AdminController::class, 'deleteReservation'])->name('admin.reservations.delete');
});