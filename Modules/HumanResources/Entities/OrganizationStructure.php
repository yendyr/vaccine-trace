<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{
    protected $fillable = [
        'uuid', 'orglevel', 'orgparent', 'orgcode', 'orgname', 'owned_by', 'status'
    ];

    protected $table = 'hr_organization_structures';

    /**
     * Get the comments for the blog post.
     */
    public function childs()
    {
        return $this->hasMany(OrganizationStructure::class, 'orgparent', 'orgcode')
            ->with('childs');
    }

}
