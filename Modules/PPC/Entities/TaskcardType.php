<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TaskcardType extends Model
{
    use Notifiable;

    protected $fillable = [
        'uuid',
        'code',
        'name',
        'description',
        'status'
    ];

}