<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{   
    protected $fillable = [
        'user_id',
        'survey_id',
        'submitted_at',
        'answers',
    ];
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
