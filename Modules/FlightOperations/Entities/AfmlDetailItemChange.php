<?php

namespace Modules\FlightOperations\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AfmlDetailItemChange extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid',

        'afm_log_id',
        'afml_detail_rectifications_id',
        'item_id_off',
        'item_id_on',
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

    public function afm_log()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmLog::class, 'afm_log_id');
    }

    public function afml_detail_rectification()
    {
        return $this->belongsTo(\Modules\FlightOperations\Entities\AfmlDetailRectification::class, 'afml_detail_rectifications_id');
    }

    public function item_id_off()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfigurationDetail::class, 'item_id_off');
    }

    public function item_id_on()
    {
        return $this->belongsTo(\Modules\PPC\Entities\AircraftConfigurationDetail::class, 'item_id_on');
    }
}