<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $user = Auth::user();
        // roles bisa lebih dari satu (Level 2, Level 3)
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        abort(403, 'Unauthorized.');
    }
}