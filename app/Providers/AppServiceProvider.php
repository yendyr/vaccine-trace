<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        $menuGroups = Menu::get()->groupBy('group');

        foreach ($menuGroups as $groupKey => $groupRow) {
            foreach ($groupRow as $menuKey => $menuRow) {
                $keys = [];
                if ($menuRow->subMenus()->count() > 0) {
                    foreach ($menuRow->subMenus as $subMenuKey => $subMenuRow) {
                        $duplicates = $groupRow->where('id', $subMenuRow->id)->keys();
                        foreach ($duplicates as $duplicateRow) {
                            $keys[] = $duplicateRow;
                        }
                    }
                }
                $groupRow->forget($keys);
            }
        }

        View::share('menuGroups', $menuGroups);
    }
}
