<?php

namespace Modules\HumanResources\Entities;

use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{
    protected $fillable = [
        'uuid', 'orglevel', 'orgparent', 'orgcode', 'orgname', 'owned_by', 'status'
    ];

    protected $table = 'organization_structures';

    /**
     * Get the comments for the blog post.
     */
    public function childs()
    {
        return $this->hasMany(OrganizationStructure::class, 'orgparent', 'orgcode')
            ->with('childs');
    }

//    public function grandchilds()
//    { //bisa dipakai recursive jika method childs tanpa ditambahkan with juga
//        return $this->childs()->with('grandchilds');
//    }
}
