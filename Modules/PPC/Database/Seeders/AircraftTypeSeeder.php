<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PPC\Entities\AircraftType;
use Illuminate\Support\Str;

class AircraftTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        AircraftType::create([
            'name' => 'Boeing 737-900ER',
            'code' => 'B737900ER',
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        AircraftType::create([
            'name' => 'Boeing 737-800NG',
            'code' => 'B737800NG',
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        AircraftType::create([
            'name' => 'Boeing 737-MAX',
            'code' => 'BMAX',
            'manufacturer_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        AircraftType::create([
            'name' => 'Airbus A320-300',
            'code' => 'A320300',
            'manufacturer_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
