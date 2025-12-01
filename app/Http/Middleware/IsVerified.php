<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsVerified
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && ! $request->user()->is_verified) {
            // For petani role, redirect to verification notice
            if ($request->user()->role === 'petani') {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
