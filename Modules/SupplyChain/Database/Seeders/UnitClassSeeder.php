<?php

namespace Modules\SupplyChain\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SupplyChain\Entities\UnitClass;
use Illuminate\Support\Str;

class UnitClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $UnitClass = UnitClass::create([
            'name' => 'Distance',
            'code' => 'DST',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Area',
            'code' => 'ARE',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Mass',
            'code' => 'MS',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Volume',
            'code' => 'VLM',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Speed',
            'code' => 'SPD',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Temperature',
            'code' => 'TMP',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Pressure',
            'code' => 'PRS',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $UnitClass = UnitClass::create([
            'name' => 'Time',
            'code' => 'TME',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
