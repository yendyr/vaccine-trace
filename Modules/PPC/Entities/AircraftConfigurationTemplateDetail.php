<?php

namespace Modules\PPC\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AircraftConfigurationTemplateDetail extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'coding',
        'aircraft_configuration_template_id',
        'item_id',
        'alias_name',
        'description',
        'parent_coding',
        
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

    public function aircraft_configuration_template()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfigurationTemplate::class, 'aircraft_configuration_template_id');
    }

    public function item()
    {
        return $this->belongsTo(\Modules\SupplyChain\Entities\Item::class, 'item_id');
    }

    public function item_group()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfigurationTemplateDetail::class, 'parent_coding', 'coding');
    }

    public function all_childs()
    {
        return $this->hasMany(\Modules\PPC\Entities\AircraftConfigurationTemplateDetail::class, 'parent_coding', 'coding')->with('all_childs');
    }
}