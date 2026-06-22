<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['survey_session_id', 'question_id', 'value'];

    protected $casts = [
        'value' => 'array'
    ];
}
