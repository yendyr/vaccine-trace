<?php

namespace Modules\GeneralSetting\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Airport extends MainModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;
    
    protected $fillable = [
        'ident', 
        'type', 
        'name', 
        'latitude_deg', 
        'longitude_deg', 
        'elevation_ft', 
        'continent', 
        'iso_country', 
        'iso_region', 
        'municipality', 
        'scheduled_service', 
        'gps_code', 
        'iata_code', 
        'local_code', 
        'home_link', 
        'wikipedia_link', 
        'keywords', 
        'description', 
        'owned_by', 
        'status', 
        'updated_by',
        'created_by',
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
}