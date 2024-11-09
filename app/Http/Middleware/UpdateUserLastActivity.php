<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentIp = $request->ip();
            
            // Update both timestamp and IP if changed
            if ($user->ip_address !== $currentIp) {
                $user->update([
                    'last_activity' => now(),
                    'ip_address' => $currentIp
                ]);
            } else {
                $user->update(['last_activity' => now()]);
            }
        }
        
        return $next($request);
    }
}