<?php

namespace App\Models;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{   protected $fillable = [
    'id',
    'title',
    'description',
    'created_at',
    'updated_at'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function submissions()
{
    return $this->hasMany(\App\Models\Submission::class);
}
}
