<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    protected $fillable = [
        'uuid', 'menu_link', 'role_id', 'menu_id', 'add', 'edit', 'delete', 'owned_by', 'status', 'created_by'
    ];

    protected $table = 'role_menus';

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
