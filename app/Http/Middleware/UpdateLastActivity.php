<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class UpdateLastActivity
{
    public function handle(Request $request, Closure $next)
    {
        session(['last_activity' => time()]);
        return $next($request);
    }
}