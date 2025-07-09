<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Task;
use App\Models\CourseUserProgress;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'phone',
        'email',
        'password',
        'salary',
        'address',
        'previous_jobs',
        'skills',
        'education'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function contracts()
    {
        return $this->belongsToMany(
            Contract::class,          // The related model
            'contract_user',        // The pivot table name (adjust spelling if needed)
            'user_id',                // Foreign key on the pivot table for the User model
            'contract_id'             // Foreign key on the pivot table for the Contract model
        );
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'courses_users');
    }
    public function progress()
    {
        return $this->hasMany(CourseUserProgress::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withTimestamps()->withPivot('completed_at');
    }
    public function completedTasks()
    {
        return $this->tasks()->wherePivotNotNull('completed_at');
    }

    public function taskPerformance()
    {
        $total = $this->tasks()->count();
        $completed = $this->completedTasks()->count();
        return $total ? round(($completed / $total) * 100, 2) : 0;
    }

    public function assignedSurveys()
    {
        return $this->belongsToMany(Survey::class)->withTimestamps();
    }
    public function submissions()
    {
        return $this->hasMany(\App\Models\Submission::class);
    }
}
