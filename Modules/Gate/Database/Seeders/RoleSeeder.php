<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Role::create([
            'role_name' => 'Super Admin',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Role::create([
            'role_name' => 'User',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Role::create([
            'role_name' => 'Engineer',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Role::create([
            'role_name' => 'Pilot in Command',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        Role::create([
            'role_name' => 'First Officer',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}