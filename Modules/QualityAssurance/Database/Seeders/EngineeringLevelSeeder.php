<?php

namespace Modules\QualityAssurance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\QualityAssurance\Entities\EngineeringLevel;
use Illuminate\Support\Str;

class EngineeringLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $EngineeringLevel = EngineeringLevel::create([
            'name' => 'Helper/Mechanic',
            'code' => 'HLP',
            'sequence_level' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $EngineeringLevel = EngineeringLevel::create([
            'name' => 'Inspection Staff',
            'code' => 'INSP',
            'sequence_level' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $EngineeringLevel = EngineeringLevel::create([
            'name' => 'Certifying Staff',
            'code' => 'CS',
            'sequence_level' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
