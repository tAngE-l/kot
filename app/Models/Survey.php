<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = ['uuid', 'title', 'user_id', 'is_active'];

    public function variants()
    {
        return $this->hasMany(SurveyVariant::class);
    }

    public function sessions()
    {
        return $this->hasMany(SurveySession::class);
    }
}
