<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class WorkOrderWorkPackageTaskcard extends MainModel
{
    use softDeletes;
    use Notifiable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'work_package_id',
        'taskcard_id',
        'description',
        'taskcard_json',
        'taskcard_group_json',
        'taskcard_type_json',
        'taskcard_workarea_json',
        'aircraft_types_json',
        'aircraft_type_details_json',
        'affected_items_json',
        'affected_item_details_json',
        'tags_json',
        'tag_details_json',
        'accesses_json',
        'access_details_json',
        'zones_json',
        'zone_details_json',
        'document_libraries_json',
        'document_library_details_json',
        'affected_manuals_json',
        'affected_manual_details_json',
        'instruction_details_json',
        'items_json',
        'item_details_json',
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

    public function work_package()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrderWorkPackage::class, 'work_package_id');
    }

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
    }
}
