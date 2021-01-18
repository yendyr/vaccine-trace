<?php

namespace Modules\QualityAssurance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\QualityAssurance\Entities\Skill;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $Skill = Skill::create([
            'name' => 'Airframe',
            'code' => 'A',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Skill = Skill::create([
            'name' => 'Powerplant',
            'code' => 'P',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Skill = Skill::create([
            'name' => 'Electrical',
            'code' => 'E',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Skill = Skill::create([
            'name' => 'Radio',
            'code' => 'R',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Skill = Skill::create([
            'name' => 'Instrument',
            'code' => 'I',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Skill = Skill::create([
            'name' => 'Cabin Maintenance',
            'code' => 'CB',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
