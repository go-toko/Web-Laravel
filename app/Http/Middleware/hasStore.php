<?php

namespace App\Http\Middleware;

use App\Models\ShopModel;
use Closure;
use Illuminate\Http\Request;

class hasStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $idShop = ShopModel::where('user_id', auth()->user()->id)->first();
        if (!$idShop) {
            return redirect(route('owner.complete-profile.index'));
        }
        return $next($request);
    }
}