<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'price', 'category', 'image'];
}