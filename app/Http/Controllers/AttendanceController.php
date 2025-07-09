<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function indexAttendance()
    {
        $user = Auth::user();
        $todayAttendance = Attendance::getTodayAttendance($user->id);

        return view('attendance.index', compact('todayAttendance'));
        // return view('attendance.index-demo');
    }

    public function clockIn()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();

        // Check if user already clocked in today
        $attendance = Attendance::getTodayAttendance($user->id);

        if ($attendance) {
            return back()->with('error', 'You have already clocked in today.');
        }

        // Save clock-in time
        Attendance::create([
            'user_id' => $user->id,
            'date' => $today,
            'clock_in' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Clocked in successfully.');
    }

    public function clockOut()
    {
        $user = Auth::user();
        $attendance = Attendance::getTodayAttendance($user->id);

        if (!$attendance || $attendance->clock_out) {
            return back()->with('error', 'You have not clocked in today or you already clocked out.');
        }

        // Save clock-out time
        $attendance->update([
            'clock_out' => Carbon::now()->toTimeString(),
        ]);

        return back()->with('success', 'Clocked out successfully.');
    }
}
