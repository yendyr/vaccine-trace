<?php

namespace Modules\Accounting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ChartOfAccountClass extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];

    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'position',
        'description',
        'status',
        'created_by',
        'updated_by',
        'owned_by',
    ];

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }

    public function chart_of_account_group()
    {
        return $this->hasMany(\Modules\Accounting\Entities\ChartOfAccountGroup::class, 'chart_of_account_class_id');
    }
}