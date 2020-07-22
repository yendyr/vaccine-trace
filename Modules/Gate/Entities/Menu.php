<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'uuid', 'menu_link', 'menu_text', 'parent', 'add', 'update', 'delete', 'approval', 'print', 'process', 'owned_by', 'created_by', 'status'
    ];
}
