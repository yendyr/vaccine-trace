<?php

namespace Modules\HumanResources\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\OrganizationStructure;

class OrganizationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        $os = OrganizationStructure::create([
//            'orglevel' => '1',
//            'orgparent' => null,
//            'orgcode' => '0001',
//            'orgname' => 'Direksi',
//            'owned_by' => 0,
//            'status' => 1,
//            'uuid' => Str::uuid(),
//        ]);
//        $os = OrganizationStructure::create([
//            'orglevel' => '2',
//            'orgparent' => '0001',
//            'orgcode' => '0002',
//            'orgname' => 'General Manager',
//            'owned_by' => 0,
//            'status' => 1,
//            'uuid' => Str::uuid(),
//        ]);
//        $os = OrganizationStructure::create([
//            'orglevel' => '3',
//            'orgparent' => '0002',
//            'orgcode' => '0003',
//            'orgname' => 'Div. Fin & Acc',
//            'owned_by' => 0,
//            'status' => 1,
//            'uuid' => Str::uuid(),
//        ]);
//        $os = OrganizationStructure::create([
//            'orglevel' => '2',
//            'orgparent' => '0001',
//            'orgcode' => '0004',
//            'orgname' => 'General HRD',
//            'owned_by' => 0,
//            'status' => 1,
//            'uuid' => Str::uuid(),
//        ]);
//        $os = OrganizationStructure::create([
//            'orglevel' => '1',
//            'orgparent' => null,
//            'orgcode' => '0005',
//            'orgname' => 'Founder',
//            'owned_by' => 0,
//            'status' => 1,
//            'uuid' => Str::uuid(),
//        ]);
    }
}
