<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\TaskcardZone;
use Illuminate\Support\Str;

class TaskcardZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $TaskcardZone = TaskcardZone::create([
            'name' => '101',
            'code' => '101',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardZone = TaskcardZone::create([
            'name' => '102',
            'code' => '102',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardZone = TaskcardZone::create([
            'name' => '203',
            'code' => '203',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $TaskcardZone = TaskcardZone::create([
            'name' => '204',
            'code' => '204',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
