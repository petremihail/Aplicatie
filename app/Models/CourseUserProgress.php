<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUserProgress extends Model
{   

    protected $fillable = [
        'user_id',
        'course_id',
        'completed_content_ids',
    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    
}
