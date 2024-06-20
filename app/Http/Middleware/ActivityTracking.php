<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActivityTracking {
 
    public function handle($request, Closure $next) {

        $user = Auth::guard('rhythmbox')->user();

        if ($user) {
            $user->last_activity = now();
            $user->active_status = 'Online';
            $user->save();
        }

        return $next($request);
    }
}
