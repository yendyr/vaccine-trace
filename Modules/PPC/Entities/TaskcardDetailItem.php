<?php

namespace Modules\PPC\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskcardDetailItem extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'taskcard_id',
        'taskcard_detail_instruction_id',
        'item_id',
        'quantity',
        'unit_id',
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

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
    }

    public function taskcard_detail_instruction()
    {
        return $this->belongsTo(\Modules\PPC\Entities\TaskcardDetailInstruction::class, 'taskcard_detail_instruction_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function unit()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Unit::class, 'unit_id');
    }

    public function category()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\ItemCategory::class, 'item_id');
    }


    // public static function boot() {
    //     parent::boot();

    //     static::deleting(function($TaskcardDetailInstruction) {
    //          $TaskcardDetailInstruction->skill_details()->delete();
    //     });
    // }
}