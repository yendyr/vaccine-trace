<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;
    
    protected $fillable = [
        'uuid', 
        'role_name', 
        'owned_by', 
        'created_by', 
        'status',
        'deleted_by',
    ];

    public function delete_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
