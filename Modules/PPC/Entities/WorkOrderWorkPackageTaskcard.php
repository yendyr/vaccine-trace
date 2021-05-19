<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class WorkOrderWorkPackageTaskcard extends MainModel
{
    use softDeletes;
    use Notifiable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'work_order_id',
        'work_package_id',
        'taskcard_id',
        'code',
        'transaction_status',
        'type',
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
        'is_exec_all',
        
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

    public function items()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailItem::class, 'taskcard_id');
    }

    public function details()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetail::class, 'taskcard_id')
            ->where('work_order_id', $this->work_order_id)
            ->where('work_package_id', $this->work_package_id);
    }

    public function progresses()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailProgress::class, 'taskcard_id')
            ->where('work_order_id', $this->work_order_id)
            ->where('work_package_id', $this->work_package_id);
    }

    public function currentUserProgress($taskcard_id)
    {
        $latest_progress = $this->progresses()
        ->where('taskcard_id', $taskcard_id)
        ->where('created_by', Auth::user()->id)->latest()->first();
        
        return $latest_progress->transaction_status ?? 1;
    }
}
