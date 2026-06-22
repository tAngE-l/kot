<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['survey_variant_id', 'type', 'question_text', 'options', 'sort_order', 'is_required'];

    
    protected $casts = [
        'options' => 'array'
    ];
}
