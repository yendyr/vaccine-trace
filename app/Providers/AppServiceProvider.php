<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Gate\Entities\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if( Schema::hasTable('menus') && Schema::hasColumns('menus', ['id', 'parent_id', 'group'])) {
            $menuGroups = Menu::whereNull('parent_id')->get()->groupBy('group');
    
            View::share('menuGroups', $menuGroups);
        }
    }
}
