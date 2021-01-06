<?php

namespace Modules\Gate\Entities;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
class Menu extends Model
{
    protected $fillable = [
        'uuid', 'menu_class', 'group', 'parent_id', 'menu_text', 'menu_link', 'menu_route', 'menu_icon', 'menu_id', 'add', 'update', 'delete', 'approval', 'print', 'process', 'owned_by', 'created_by', 'menu_actives', 'status'
    ];

    /** 
     * Function to get all childs menu from given menu.
     */
    public function subMenus()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    /**
     * Function to render url from a given menu.
     */
    public function renderLink()
    {
        $route = ($this->menu_route) ? route($this->menu_route) : null;
        $link = ($this->menu_link) ? url($this->menu_link) : null;

        return $route ?? $link ?? '#';
    }

    /** 
     * Function to check if there is any active sub menus
     */
    public function hasActiveSubMenus(Request $request)
    {
        $canView = false;

        if ( $request->user()->can('viewAny', $this->menu_class) ) $canView = true;

        if ( $this->subMenus()->count() > 0 ) {
            foreach ($this->subMenus as $subMenu) {
                if ( $request->user()->can('viewAny', $subMenu->menu_class) ) $canView = true;
            }
        } 

        return $canView;
    }

    public function isActive(Request $request)
    {
        $isActive = null;

        $actives = json_decode($this->menu_actives);

        if( !empty($actives) ){
            foreach ($actives as $activeRow) {
                if( $request->is($activeRow) ) $isActive = 'active';
            }
        }
        
        if ( $this->subMenus()->count() > 0 ) {
            foreach ($this->subMenus as $subMenu) {
                $actives = json_decode($subMenu->menu_actives);

                if( !empty($actives) ){
                    foreach ($actives as $activeRow) {
                        if( $request->is($activeRow) ) $isActive = 'active';
                    }
                }
            }
        } 

        return $isActive;
    }

    /**
     * Function to decode json menu_actives
     * and return array of active clasess
     */
    public function getActiveClasses()
    {
        return json_decode($this->menu_actives);
    }

}
