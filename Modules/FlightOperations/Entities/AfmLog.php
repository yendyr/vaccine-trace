<?php

namespace Modules\FlightOperations\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class AfmLog extends MainModel
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

        'total_flight_hour',
        'total_block_hour',
        'total_flight_cycle',
        'total_flight_event',

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
        return $this->belongsTo(\Modules\HumanResources\Entities\Employee::class, 'pre_flight_check_person_id');
    }

    public function post_flight_check_nearest_airport()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Airport::class, 'post_flight_check_nearest_airport_id');
    }

    public function post_flight_check_person()
    {
        return $this->belongsTo(\Modules\HumanResources\Entities\Employee::class, 'post_flight_check_person_id');
    }

    public function crew_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailCrew::class, 'afm_log_id');
    }

    public function item_record_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailItemRecord::class, 'afm_log_id');
    }

    public function dmi_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailDmi::class, 'afm_log_id');
    }

    public function manifest_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailManifest::class, 'afm_log_id');
    }

    public function journal_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailJournal::class, 'afm_log_id');
    }

    public function discrepancy_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailDiscrepancy::class, 'afm_log_id');
    }

    public function rectification_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailRectification::class, 'afm_log_id');
    }

    public function item_change_details()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlDetailItemChange::class, 'afm_log_id');
    }

    public function approvals()
    {
        return $this->hasMany(\Modules\FlightOperations\Entities\AfmlApproval::class, 'afm_log_id');
    }

    public function item_stock_aging_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\ItemStockAging::class, 'transaction_reference_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($AfmLog) {
             $AfmLog->crew_details()->delete();
             $AfmLog->item_record_details()->delete();
             $AfmLog->dmi_details()->delete();
             $AfmLog->manifest_details()->delete();
             $AfmLog->journal_details()->delete();
             $AfmLog->discrepancy_details()->delete();
             $AfmLog->rectification_details()->delete();
             $AfmLog->item_change_details()->delete();
             $AfmLog->approvals()->delete();
             $AfmLog->item_stock_aging_details()->delete();
        });
    }
}