<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GeneralSettingDatabaseSeeder extends Seeder
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
            CountrySeeder::class,
            CompanySeeder::class,
            CompanyDetailContactSeeder::class,
            CompanyDetailAddressSeeder::class,
            CompanyDetailBankSeeder::class,
            AirportSeeder::class,
        ]);
    }
}
