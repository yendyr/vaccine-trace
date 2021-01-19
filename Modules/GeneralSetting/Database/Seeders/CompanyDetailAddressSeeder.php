<?php

namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\GeneralSetting\Entities\CompanyDetailAddress;
use Illuminate\Support\Str;

class CompanyDetailAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        CompanyDetailAddress::create([
            'company_id' => 4,
            'label' => 'Primary Contact',
            'name' => 'Customer Service',
            'street' => 'Wakanda Empire 445',
            'city' => 'Wellington',
            'province' => 'Arkansas',
            'country_id' => 44,
            'post_code' => '56498',
            'latitude' => '56419684',
            'longitude' => '-897984152',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        CompanyDetailAddress::create([
            'company_id' => 4,
            'label' => 'Seattle Branch',
            'name' => 'Heer Gaahn',
            'street' => 'Seattle Boulevard VII, X77',
            'city' => 'Seattle',
            'province' => 'Marlboro',
            'country_id' => 2,
            'post_code' => '56498',
            'latitude' => '564',
            'longitude' => '-87',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        CompanyDetailAddress::create([
            'company_id' => 4,
            'label' => 'Jakarta Branch',
            'name' => 'Suharyono',
            'street' => 'Kuningan Mega Komplek Building',
            'city' => 'Jakarta',
            'province' => 'Jakarta',
            'country_id' => 62,
            'post_code' => '60235',
            'latitude' => '564',
            'longitude' => '-87',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
