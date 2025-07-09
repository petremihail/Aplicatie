<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in.');
        }
        
        // Ensure the user has a roles() relationship
        $user = $request->user();
        
        // Check if user has any of the roles provided
        if (!$user->roles()->whereIn('name', $roles)->exists()) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
