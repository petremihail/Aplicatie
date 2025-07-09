<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{   

    protected $fillable = [
        'id',
        'question',
        'type',
        'created_at',
        'updated_at'
    ];
    public function surveys()
    {
        return $this->belongsToMany(Survey::class)->withTimestamps();
    }
}
