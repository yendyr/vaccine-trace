<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Taskcard extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        
        'mpd_number',
        'title',
        'taskcard_group_id',
        'taskcard_type_id',
        'compliance',
        'threshold_flight_hour',
        'threshold_flight_cycle',
        'threshold_daily',
        'threshold_daily_unit',
        'threshold_date',
        'repeat_flight_hour',
        'repeat_flight_cycle',
        'repeat_daily',
        'repeat_daily_unit',
        'repeat_date',
        'interval_control_method',

        'company_number',
        'ata',
        'issued_date',
        'version',
        'revision',
        'effectivity',
        'taskcard_workarea_id',
        'source',
        'reference',
        'file_attachment',
        'scheduled_priority',
        'recurrence',

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
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardGroup::class, 'taskcard_group_id');
    }

    public function taskcard_type()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardType::class, 'taskcard_type_id');
    }

    public function taskcard_workarea()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardWorkarea::class, 'taskcard_workarea_id');
    }

    public function aircraft_types()
    {
        return $this->belongsToMany(\Modules\PPC\Entities\AircraftType::class, 'taskcard_detail_aircraft_types');
    }

    public function aircraft_type_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailAircraftType::class, 'taskcard_id');
    }

    public function affected_items()
    {
        return $this->belongsToMany(\Modules\SupplyChain\Entities\Item::class, 'taskcard_detail_affected_items','taskcard_id','affected_item_id');
    }

    public function affected_item_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailAffectedItem::class, 'taskcard_id');
    }

    public function accesses()
    {
        return $this->belongsToMany(\Modules\PPC\Entities\TaskcardAccess::class, 'taskcard_detail_accesses');
    }

    public function access_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailAccess::class, 'taskcard_id');
    }

    public function zones()
    {
        return $this->belongsToMany(\Modules\PPC\Entities\TaskcardZone::class, 'taskcard_detail_zones');
    }

    public function zone_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailZone::class, 'taskcard_id');
    }

    public function document_libraries()
    {
        return $this->belongsToMany(\Modules\PPC\Entities\TaskcardDocumentLibrary::class, 'taskcard_detail_document_libraries');
    }

    public function document_library_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailDocumentLibrary::class, 'taskcard_id');
    }

    public function affected_manuals()
    {
        return $this->belongsToMany(\Modules\QualityAssurance\Entities\DocumentType::class, 'taskcard_detail_affected_manuals','taskcard_id','taskcard_affected_manual_id');
    }

    public function affected_manual_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailAffectedManual::class, 'taskcard_id');
    }

    public function instruction_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailInstruction::class, 'taskcard_id');
    }

    public function item_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailItem::class, 'taskcard_id');
    }

    public function items()
    {
        return $this->belongsToMany(\Modules\SupplyChain\Entities\Item::class, 'taskcard_detail_items');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($Taskcard) {
             $Taskcard->aircraft_type_details()->delete();
             $Taskcard->affected_item_details()->delete();
             $Taskcard->access_details()->delete();
             $Taskcard->zone_details()->delete();
             $Taskcard->document_library_details()->delete();
             $Taskcard->affected_manual_details()->delete();
             $Taskcard->instruction_details()->delete();
             $Taskcard->item_details()->delete();
        });
    }
}