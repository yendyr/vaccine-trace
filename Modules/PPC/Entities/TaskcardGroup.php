<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class TaskcardGroup extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',

        'name',
        'description',
        'parent_id',

        'status',
        'created_by',
        'updated_by',
        'owned_by',
        'deleted_by',
    ];

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }

    public function taskcard_group()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardGroup::class, 'parent_id');
    }

    public function subGroup()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardGroup::class, 'parent_id');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardGroup::class, 'parent_id', 'id')->with('all_childs');
    }
}