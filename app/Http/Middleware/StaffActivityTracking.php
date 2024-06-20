<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StaffActivityTracking {
 
    public function handle($request, Closure $next) {

        $user = Auth::guard('staff')->user();

        if ($user) {
            $user->last_activity = now();
            $user->status = 'Online';
            $user->save();
        }

        return $next($request);
    }
}
