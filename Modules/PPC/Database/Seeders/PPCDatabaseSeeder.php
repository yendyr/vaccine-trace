<?php

namespace Modules\PPC\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PPCDatabaseSeeder extends Seeder
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
            AircraftTypeSeeder::class,
            TaskcardGroupSeeder::class,
            TaskcardTypeSeeder::class,
            TaskcardZoneSeeder::class,
            TaskcardAccessSeeder::class,
            TaskcardWorkareaSeeder::class,
            TaskcardDocumentLibrarySeeder::class,
        ]);
    }
}
