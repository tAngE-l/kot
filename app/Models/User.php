<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    public $timestamps = false; // Отключаем timestamps
    
    protected $fillable = ['username', 'email', 'password', 'is_admin'];
    protected $hidden = ['password'];
}