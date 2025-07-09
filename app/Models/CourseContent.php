<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',  // Add course_id to the fillable array
        'title',
        'type',
        'file_path',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
