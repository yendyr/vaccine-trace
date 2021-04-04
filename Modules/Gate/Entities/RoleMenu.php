<?php

namespace Modules\Gate\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleMenu extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;
    
    protected $fillable = [
        'uuid', 
        'menu_link', 
        'role_id', 
        'menu_id', 
        'add', 
        'update', 
        'delete', 
        'approval', 
        'print', 
        'process', 
        'owned_by', 
        'status', 
        'created_by',
        'deleted_by',
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

    public function delete_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
