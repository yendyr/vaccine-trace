<?php

namespace Modules\Gate\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [];

    /**
     * Retrieve the child model for a bound value.
     *
     * @param string $childType
     * @param mixed $value
     * @param string|null $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveChildRouteBinding($childType, $value, $field)
    {
        // TODO: Implement resolveChildRouteBinding() method.
    }
}
