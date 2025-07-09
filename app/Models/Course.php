<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'category', 'created_at', 'updated_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'courses_users');
    }
    public function contents()
    {
        return $this->hasMany(CourseContent::class);
    }
}
