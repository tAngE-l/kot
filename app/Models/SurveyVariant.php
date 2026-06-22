<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyVariant extends Model
{
    protected $fillable = ['survey_id', 'name', 'description'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
