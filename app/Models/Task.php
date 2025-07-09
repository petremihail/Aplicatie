<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'description',
        'due_date',
        'created_at', 'updated_at',
        'priority_id',
        'points',
        'completed_at',
    ];
    public function users()
{
    return $this->belongsToMany(User::class)->withTimestamps()->withPivot('completed_at');
}
public function priority()
{
    return $this->belongsTo(Priority::class);
}

}
