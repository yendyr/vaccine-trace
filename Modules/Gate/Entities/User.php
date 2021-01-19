<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use softDeletes;
    protected $dates = ['deleted_at'];
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'name', 
        'username', 
        'email', 
        'password', 
        'image', 
        'role_id', 
        'company_id', 
        'owned_by', 
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Retrieve the child model for a bound value.
     *
     * @param string $childType
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function company()
    {
        return $this->belongsTo(\Modules\GeneralSetting\Entities\Company::class, 'company_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function delete_by()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}