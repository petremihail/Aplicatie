<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'clock_in', 'clock_out'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getTodayAttendance($userId)
    {
        return self::where('user_id', $userId)
            ->where('date', Carbon::today()->toDateString())
            ->first();
    }
}
