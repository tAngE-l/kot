<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';
    public $timestamps = false;
    
    protected $fillable = [
        'user_id', 'name', 'phone', 'email', 
        'date', 'time', 'guests', 'notes', 'status'
    ];
    
    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}