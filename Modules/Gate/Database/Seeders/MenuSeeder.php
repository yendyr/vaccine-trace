<?php

namespace Modules\Gate\Database\Seeders;

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
            ModuleMenu\GateMenuSeeder::class,
            // ModuleMenu\HumanResourcesMenuSeeder::class,
            // ModuleMenu\GeneralSettingMenuSeeder::class,
            // ModuleMenu\AccountingMenuSeeder::class,
            // ModuleMenu\QualityAssuranceMenuSeeder::class,
            // ModuleMenu\SupplyChainMenuSeeder::class,
            // ModuleMenu\PPCMenuSeeder::class,
            // ModuleMenu\FlightOperationsMenuSeeder::class,
            // ModuleMenu\ProcurementMenuSeeder::class,
        ]);
    }
}
