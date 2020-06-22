<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['uuid', 'role_name', 'owned_by', 'created_by', 'status'];
}
