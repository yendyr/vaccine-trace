<?php

namespace Modules\FlightOperations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AircraftFlightMaintenanceLog extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'page_number',
        'previous_page_number',
        'transaction_date',
        'aircraft_configuration_id',
        'last_inspection',
        'next_inspection',

        'pre_flight_check_date',
        'pre_flight_check_place',
        'pre_flight_check_nearest_airport_id',
        'pre_flight_check_person_id',
        'pre_flight_check_compressor_wash',

        'post_flight_check_date',
        'post_flight_check_place',
        'post_flight_check_nearest_airport_id',
        'post_flight_check_person_id',
        'post_flight_check_compressor_wash',

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

    public function aircraft_configuration()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfiguration::class, 'aircraft_configuration_id');
    }

    public function pre_flight_check_nearest_airport()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Airport::class, 'pre_flight_check_nearest_airport_id');
    }

    public function pre_flight_check_person()
    {
        return $this->belongsTo(\Modules\PPC\HumanResources\Employee::class, 'pre_flight_check_person_id');
    }

    public function post_flight_check_nearest_airport()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Airport::class, 'post_flight_check_nearest_airport_id');
    }

    public function post_flight_check_person()
    {
        return $this->belongsTo(\Modules\PPC\HumanResources\Employee::class, 'post_flight_check_person_id');
    }

    // public function aircraft_types()
    // {
    //     return $this->belongsToMany(\Modules\PPC\Entities\AircraftType::class, 'taskcard_detail_aircraft_types');
    // }

    public function manpower_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailManpower::class, 'aircraft_flight_maintenance_logs_id');
    }

    // public function affected_items()
    // {
    //     return $this->belongsToMany(\Modules\SupplyChain\Entities\Item::class, 'taskcard_detail_affected_items','taskcard_id','affected_item_id');
    // }

    public function item_record_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailItemRecord::class, 'aircraft_flight_maintenance_logs_id');
    }

    // public function accesses()
    // {
    //     return $this->belongsToMany(\Modules\PPC\Entities\TaskcardAccess::class, 'taskcard_detail_accesses');
    // }

    public function defered_maintenance_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailDeferedMaintenance::class, 'aircraft_flight_maintenance_logs_id');
    }

    // public function zones()
    // {
    //     return $this->belongsToMany(\Modules\PPC\Entities\TaskcardZone::class, 'taskcard_detail_zones');
    // }

    public function manifest_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailManifest::class, 'aircraft_flight_maintenance_logs_id');
    }

    // public function document_libraries()
    // {
    //     return $this->belongsToMany(\Modules\PPC\Entities\TaskcardDocumentLibrary::class, 'taskcard_detail_document_libraries');
    // }

    public function journal_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailJournal::class, 'aircraft_flight_maintenance_logs_id');
    }

    // public function affected_manuals()
    // {
    //     return $this->belongsToMany(\Modules\QualityAssurance\Entities\DocumentType::class, 'taskcard_detail_affected_manuals','taskcard_id','taskcard_affected_manual_id');
    // }

    public function discrepancy_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailDiscrepancy::class, 'aircraft_flight_maintenance_logs_id');
    }

    public function rectification_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailRectification::class, 'aircraft_flight_maintenance_logs_id');
    }

    public function item_change_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AircraftFlightMaintenanceLogDetailItemChange::class, 'aircraft_flight_maintenance_logs_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($AFML) {
             $AFML->manpower_details()->delete();
             $AFML->item_record_details()->delete();
             $AFML->defered_maintenance_details()->delete();
             $AFML->manifest_details()->delete();
             $AFML->journal_details()->delete();
             $AFML->discrepancy_details()->delete();
             $AFML->rectification_details()->delete();
             $AFML->item_change_details()->delete();
        });
    }
}