<?php

namespace Modules\QualityAssurance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\QualityAssurance\Entities\TaskReleaseLevel;
use Illuminate\Support\Str;

class TaskReleaseLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskReleaseLevel = TaskReleaseLevel::create([
            'name' => 'Standard Release',
            'code' => 'SR',
            'sequence_level' => 1,
            'authorized_engineering_level' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskReleaseLevel = TaskReleaseLevel::create([
            'name' => 'RII Release',
            'code' => 'RII',
            'sequence_level' => 1,
            'authorized_engineering_level' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
