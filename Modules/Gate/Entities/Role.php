<?php

namespace Modules\Gate\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;
    
    protected $fillable = [
        'uuid',

        'code', 
        'role_name', 
        'role_name_alias', 
        'description', 
        'is_in_flight_role', 

        'owned_by', 
        'created_by', 
        'status',
        'deleted_by',
    ];

    public function delete_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }
}
