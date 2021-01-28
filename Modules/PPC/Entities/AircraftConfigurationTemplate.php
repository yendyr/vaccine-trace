<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AircraftConfigurationTemplate extends Model
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

    public function manufacturer()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Company::class, 'aircraft_type_id');
    }

    public function aircraft_configuration_template_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\AircraftConfigurationTemplateDetail::class, 'aircraft_configuration_template_details_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($AircraftConfigurationTemplate) {
            if (sizeof($AircraftConfigurationTemplate->aircraft_configuration_template_details) > 0) {
                $AircraftConfigurationTemplate->aircraft_configuration_template_details()->delete();
            }             
        });
    }
}