<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class WOWPTaskcardDetail extends MainModel
{
    use softDeletes;
    use Notifiable;

    protected $table = 'wo_wp_taskcard_details';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'uuid',

        'work_order_id',
        'work_package_id',
        'taskcard_id',
        
        'code', 
        'sequence',
        'instruction_code',
        'taskcard_workarea_id',
        'manhours_estimation',
        'performance_factor',
        'engineering_level_id',
        'manpower_quantity',
        'task_release_level_id',
        'instruction',
        'transaction_status',
        'skills_json',
        'taskcard_workarea_json',
        'engineering_level_json',
        'task_release_level_json',

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

    public function work_order()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrder::class, 'work_order_id');
    }

    public function work_package()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrderWorkPackage::class, 'work_package_id');
    }

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrderWorkPackageTaskcard::class, 'taskcard_id');
    }

    public function taskcard_workarea()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardWorkarea::class, 'taskcard_workarea_id');
    }

    public function engineering_level()
    {
        return $this->belongsTo(\Modules\QualityAssurance\Entities\EngineeringLevel::class, 'engineering_level_id');
    }

    public function task_release_level()
    {
        return $this->belongsTo(\Modules\QualityAssurance\Entities\TaskReleaseLevel::class, 'task_release_level_id');
    }

    public function skill_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailInstructionSkill::class, 'taskcard_detail_instruction_id', 'detail_id');
    }

    public function items()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailItem::class, 'detail_id');
    }

    public function progresses()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailProgress::class, 'detail_id')
            ->where('work_order_id', $this->work_order_id)
            ->where('work_package_id', $this->work_package_id)
            ->where('taskcard_id', $this->taskcard_id);
    }

    public function currentUserProgress($detail_id)
    {
        $latest_progress = $this->progresses()
        ->where('detail_id', $detail_id)
        ->where('created_by', Auth::user()->id)->latest()->first();

        return $latest_progress->transaction_status ?? 1;
    }
}
