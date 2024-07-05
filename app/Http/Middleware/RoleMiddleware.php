<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        $role = Auth::user()->role->name;
        switch ($role) {
            case 'Superadmin':
                return redirect(route('superadmin.dashboard'));
            case 'Owner':
                return redirect(route('owner.dashboard'));
            case 'Cashier':
                return redirect(route('cashier.dashboard'));
            default:
                return redirect(route('login'));
        }
    }
}
