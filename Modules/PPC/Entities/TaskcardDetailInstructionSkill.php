<?php

namespace Modules\PPC\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskcardDetailInstructionSkill extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',
        'taskcard_detail_instruction_id',
        'skill_id',
        'description',

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

    public function taskcard_detail_instruction()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardDetailInstruction::class, 'taskcard_detail_instruction_id');
    }

    public function skill()
    {
        return $this->belongsTo(\Modules\QualityAssurance\Entities\Skill::class, 'skill_id');
    }
}