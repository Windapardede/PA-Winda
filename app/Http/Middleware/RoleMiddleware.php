<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            // Redirect kalau tidak sesuai
            if ($request->user()->role === 'user') {
                return redirect('/posisi');
            }

            return redirect('/home');
        }

        return $next($request);
    }
}
