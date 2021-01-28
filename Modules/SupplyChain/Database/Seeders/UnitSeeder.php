<?php

namespace Modules\SupplyChain\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SupplyChain\Entities\Unit;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Unit::create([
            'name' => 'Meter',
            'code' => 'M',
            'unit_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Centimeter',
            'code' => 'Cm',
            'unit_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Inch',
            'code' => 'I',
            'unit_class_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Meter Square',
            'code' => 'M2',
            'unit_class_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Hectare',
            'code' => 'H',
            'unit_class_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Kilometer Square',
            'code' => 'Km2',
            'unit_class_id' => 2,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Gram',
            'code' => 'Gr',
            'unit_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Kilo Gram',
            'code' => 'Kg',
            'unit_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Ton',
            'code' => 'T',
            'unit_class_id' => 3,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Litre',
            'code' => 'L',
            'unit_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Ounce',
            'code' => 'Oz',
            'unit_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Mili Liter',
            'code' => 'Ml',
            'unit_class_id' => 4,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Km/H',
            'code' => 'KMH',
            'unit_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Knot',
            'code' => 'KN',
            'unit_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Mil/H',
            'code' => 'Mph',
            'unit_class_id' => 5,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Celcius',
            'code' => 'C',
            'unit_class_id' => 6,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Fahrenheit',
            'code' => 'F',
            'unit_class_id' => 6,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Kelvin',
            'code' => 'K',
            'unit_class_id' => 6,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Bar',
            'code' => 'B',
            'unit_class_id' => 7,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Psi',
            'code' => 'P',
            'unit_class_id' => 7,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Atmosphere',
            'code' => 'A',
            'unit_class_id' => 7,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Unit::create([
            'name' => 'Hour',
            'code' => 'Hr',
            'unit_class_id' => 8,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Day',
            'code' => 'D',
            'unit_class_id' => 8,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Week',
            'code' => 'Wk',
            'unit_class_id' => 8,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Each',
            'code' => 'EA',
            'unit_class_id' => 9,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Pieces',
            'code' => 'PCS',
            'unit_class_id' => 9,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Unit::create([
            'name' => 'Box',
            'code' => 'BX',
            'unit_class_id' => 9,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
