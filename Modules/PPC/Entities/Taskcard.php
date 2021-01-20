<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'threshold_flight_hour',
        'threshold_flight_cycle',
        'threshold_day_count',
        'threshold_date',
        'repeat_flight_hour',
        'repeat_flight_cycle',
        'repeat_day_count',
        'repeat_date',
        'interval_control_method',

        'company_number',
        'ata',
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

    public function access_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailAccess::class, 'taskcard_id');
    }

    public function zone_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailZone::class, 'taskcard_id');
    }

    public function document_library_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailDocumentLibrary::class, 'taskcard_id');
    }

    public function affected_manual_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailAffectedManual::class, 'taskcard_id');
    }
}