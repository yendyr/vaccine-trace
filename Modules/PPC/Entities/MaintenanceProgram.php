<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class MaintenanceProgram extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'aircraft_type_id',
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

    public function aircraft_type()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftType::class, 'aircraft_type_id');
    }

    public function maintenance_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\MaintenanceProgramDetail::class, 'maintenance_program_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\PPC\Entities\MaintenanceProgramApproval::class, 'maintenance_program_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($MaintenanceProgram) {           
            $MaintenanceProgram->maintenance_details()->delete();             
            $MaintenanceProgram->approvals()->delete();             
        });
    }
}