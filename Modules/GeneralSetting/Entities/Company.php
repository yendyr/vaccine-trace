<?php

namespace Modules\GeneralSetting\Entities;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    protected $fillable = [
        'uuid', 
        'code', 
        'name', 
        'gst_number', 
        'npwp_number', 
        'description', 
        'is_customer', 
        'is_supplier', 
        'is_manufacturer', 
        'owned_by', 
        'status', 
        'updated_by',
        'created_by'
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