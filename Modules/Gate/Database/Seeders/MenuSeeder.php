<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MenuSeeder extends Seeder
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
            GateMenuSeeder::class,
            HumanResourcesMenuSeeder::class,
            GeneralSettingMenuSeeder::class,
            AccountingMenuSeeder::class,
            QualityAssuranceMenuSeeder::class,
            SupplyChainMenuSeeder::class,
            PPCMenuSeeder::class,
            FlightOperationsMenuSeeder::class,
        ]);
    }
}