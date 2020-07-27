<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class OrganizationStructureTitle extends Model
{
    protected $fillable = [
        'uuid', 'orgcode', 'titlecode', 'jobtitle', 'rptorg', 'rpttitle', 'status', 'created_by'
    ];

    protected $table = 'organization_structure_titles';

    public function organizationStructure()
    {
        return $this->belongsTo(OrganizationStructure::class, 'orgcode', 'orgcode');
    }
}
