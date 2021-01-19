<?php

namespace Modules\SupplyChain\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SupplyChain\Entities\Warehouse;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $Warehouse = Warehouse::create([
            'name' => 'Material Warehouse',
            'code' => 'MW',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Warehouse = Warehouse::create([
            'name' => 'Tools Warehouse',
            'code' => 'TW',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $Warehouse = Warehouse::create([
            'name' => 'Chemical Warehouse',
            'code' => 'CW',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}