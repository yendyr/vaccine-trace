<?php

namespace Modules\QualityAssurance\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Skill extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];

    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'description',
        'status',
        'created_by',
        'updated_by',
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