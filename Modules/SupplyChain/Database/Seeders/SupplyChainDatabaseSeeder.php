<?php

namespace Modules\SupplyChain\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SupplyChainDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            WarehouseSeeder::class,
            UnitClassSeeder::class,
            UnitSeeder::class,
            ItemCategorySeeder::class,
            ItemSeeder::class,
        ]);
    }
}
