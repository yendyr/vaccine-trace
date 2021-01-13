<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
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
        'created_by'
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