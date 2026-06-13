<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, string $role = 'admin')
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access this area.');
        }

        if ($role === 'super_admin' && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Super admin access required.');
        }

        if (!auth()->user()->isAdmin()) {
            abort(403, 'Admin access required.');
        }

        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been deactivated.');
        }

        return $next($request);
    }
}
