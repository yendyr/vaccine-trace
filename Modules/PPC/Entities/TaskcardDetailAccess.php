<?php

namespace Modules\PPC\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskcardDetailAccess extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        'taskcard_id',
        'taskcard_access_id',
        'description',

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

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
    }

    public function taskcard_access()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardAccess::class, 'taskcard_access_id');
    }
}