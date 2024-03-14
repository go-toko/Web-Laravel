<?php

namespace App\Providers;

use App\Models\RoleMenuModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $roleId = Auth::user()->role_id;
                // $menus = Cache::remember('menus_' . $roleId, 60 * 60 * 24, function () use ($roleId) {
                //     return RoleMenuModel::where('role_id', $roleId)->with('menu.subMenu')->orderBy('order')->get();
                // });
                $menus = RoleMenuModel::where('role_id', $roleId)->with('menu.subMenu')->orderBy('order')->get();
                $view->with('menus', $menus);
            }
        });
    }
}
