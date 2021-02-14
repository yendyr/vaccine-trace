<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\TaskcardGroup;
use Illuminate\Support\Str;

class TaskcardGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Routine',
            'code' => 'RTN',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Non Routine',
            'code' => 'NRTN',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Basic',
            'code' => 'BSC',
            'status' => 1,
            'parent_id' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Structure Inspection Program',
            'code' => 'SIP',
            'status' => 1,
            'parent_id' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Corrosion Preventive & Control Program',
            'code' => 'CPCP',
            'status' => 1,
            'parent_id' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Airworthiness Directive/Service Bulletin',
            'code' => 'ADSB',
            'status' => 1,
            'parent_id' => 2,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Hard Time',
            'code' => 'HT/CRR',
            'status' => 1,
            'parent_id' => 2,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'On Condition',
            'code' => 'OC',
            'status' => 1,
            'parent_id' => 2,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardGroup = TaskcardGroup::create([
            'name' => 'Special Instruction',
            'code' => 'SI',
            'status' => 1,
            'parent_id' => 2,
            'uuid' => Str::uuid(),
        ]);
        // $TaskcardGroup = TaskcardGroup::create([
        //     'name' => 'Airworthiness Directive',
        //     'code' => 'AD',
        //     'status' => 1,
        //     'parent_id' => 7,
        //     'uuid' => Str::uuid(),
        // ]);
        // $TaskcardGroup = TaskcardGroup::create([
        //     'name' => 'Service Buletin',
        //     'code' => 'SB',
        //     'status' => 1,
        //     'parent_id' => 7,
        //     'uuid' => Str::uuid(),
        // ]);
        // $TaskcardGroup = TaskcardGroup::create([
        //     'name' => 'Engineering Authorization',
        //     'code' => 'EA',
        //     'status' => 1,
        //     'parent_id' => 7,
        //     'uuid' => Str::uuid(),
        // ]);
        // $TaskcardGroup = TaskcardGroup::create([
        //     'name' => 'Certification Maintenance Requirement',
        //     'code' => 'CMR',
        //     'status' => 1,
        //     'parent_id' => 7,
        //     'uuid' => Str::uuid(),
        // ]);
        // $TaskcardGroup = TaskcardGroup::create([
        //     'name' => 'Airworthiness Limitation',
        //     'code' => 'AWL',
        //     'status' => 1,
        //     'parent_id' => 7,
        //     'uuid' => Str::uuid(),
        // ]);
    }
}
