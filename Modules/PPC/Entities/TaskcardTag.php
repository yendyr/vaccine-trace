<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class TaskcardTag extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'code',
        'name',
        'description',

        // 'threshold_flight_hour',
        // 'threshold_flight_cycle',
        // 'threshold_daily',
        // 'threshold_daily_unit',
        // 'threshold_date',
        
        // 'repeat_flight_hour',
        // 'repeat_flight_cycle',
        // 'repeat_daily',
        // 'repeat_daily_unit',
        // 'repeat_date',
        // 'interval_control_method',

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

    // public function taskcards()
    // {
    //     return $this->hasMany(\Modules\PPC\Entities\Taskcard::class, 'taskcard_interval_group_id');
    // }
}