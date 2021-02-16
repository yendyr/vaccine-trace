<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MaintenanceProgramDetail extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'maintenance_program_id',
        'taskcard_id',

        'code',
        'name',
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

    public function maintenance_program()
    {
        return $this->belongsTo(\Modules\PPC\Entities\MaintenanceProgram::class, 'maintenance_program_id');
    }

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
    }
}