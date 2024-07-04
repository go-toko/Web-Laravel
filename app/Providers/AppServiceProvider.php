<?php

namespace App\Providers;

use App\Models\RoleMenuModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
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

                // Get Cachye for menu
                $menu = Cache::get('menus', function () use ($roleId) {
                    $data = RoleMenuModel::where('role_id', $roleId)->with('menu.subMenu')->orderBy('order')->get();
                    Cache::put('menus', $data, 60 * 60 * 24);
                    return $data;
                });

                $view->with('menus', $menu);
            }
        });
    }
}
