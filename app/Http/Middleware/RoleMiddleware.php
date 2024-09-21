<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Auth;
use Closure;
use Illuminate\Http\Request;

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
        return match ($role) {
            'Superadmin' => redirect(~route('superadmin.dashboard')),
            'Owner' => redirect(route('owner.dashboard')),
            'Cashier' => redirect(route('cashier.dashboard')),
            default => redirect(RouteServiceProvider::HOME),
        };

        return redirect('login');
    }
}
