<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveySession extends Model
{
   
    protected $table = 'survey_sessions';

  
    protected $fillable = [
        'survey_id', 
        'survey_variant_id', 
        'user_id', 
        'started_at', 
        'completed_at', 
        'status'
    ];

   
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];


    public function variant()
    {
        return $this->belongsTo(SurveyVariant::class, 'survey_variant_id');
    }


    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
