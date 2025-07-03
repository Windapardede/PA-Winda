<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticatedByRole
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $role = Auth::user()->role;

            if (in_array($role, ['admin', 'mentor', 'hrd'])) {
                return redirect('/home');
            }

            if ($role === 'user') {
                return redirect('/posisi');
            }

            // fallback
            return redirect('/');
        }

        return $next($request);
    }
}
