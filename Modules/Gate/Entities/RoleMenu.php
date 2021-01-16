<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;
    
    protected $fillable = [
        'uuid', 'menu_link', 'role_id', 'menu_id', 'add', 'update', 'delete', 'approval', 'print', 'process', 'owned_by', 'status', 'created_by'
    ];

    protected $table = 'role_menus';

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
