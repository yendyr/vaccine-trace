<?php

namespace Modules\GeneralSetting\Entities;

use App\SACModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Country extends SACModel
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'iso',
        'iso_3',
        'name',
        'nice_name',
        'num_code',
        'phone_code',
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
}