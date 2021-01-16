<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;
    
    protected $fillable = ['uuid', 'role_name', 'owned_by', 'created_by', 'status'];
}
