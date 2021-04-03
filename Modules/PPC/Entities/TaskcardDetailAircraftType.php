<?php

namespace Modules\PPC\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskcardDetailAircraftType extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        'taskcard_id',
        'aircraft_type_id',
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

    public function aircraft_type()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftType::class, 'aircraft_type_id');
    }
}