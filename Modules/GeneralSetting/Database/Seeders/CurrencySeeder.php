<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\Currency;
use Illuminate\Support\Str;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Currency::create([
            'name' => 'Indonesia Rupiah',
            'code' => 'IDR',
            'symbol' => 'Rp.',
            'description' => 'Indonesia Rupiah',
            'country_id' => 100,
            'is_primary' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        Currency::create([
            'name' => 'US Dollar',
            'code' => 'USD',
            'symbol' => '$',
            'description' => 'US Dollar',
            'country_id' => 226,
            'is_primary' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}