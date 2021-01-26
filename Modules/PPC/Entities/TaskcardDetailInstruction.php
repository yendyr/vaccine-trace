<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskcardDetailInstruction extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'sequence',
        'taskcard_id',
        'taskcard_workarea_id',
        'manhours_estimation',
        'performance_factor',
        'engineering_level_id',
        'manpower_quantity',
        'task_release_level_id',
        'instruction',

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

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
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

    public function skills()
    {
        return $this->belongsToMany(\Modules\QualityAssurance\Entities\Skill::class, 'taskcard_detail_instruction_skills');
    }

    public function skill_details()
    {
        return $this->hasMany(\Modules\PPC\Entities\TaskcardDetailInstructionSkill::class, 'taskcard_detail_instruction_id');
    }

    public function item_details()
    {
        return $this->hasMany(\Modules\SupplyChain\Entities\TaskcardDetailItem::class, 'taskcard_detail_instruction_id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($TaskcardDetailInstruction) {
             $TaskcardDetailInstruction->skill_details()->delete();
             $TaskcardDetailInstruction->item_details()->delete();
        });
    }
}