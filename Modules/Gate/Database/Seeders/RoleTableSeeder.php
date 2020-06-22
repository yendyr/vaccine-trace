<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $role = Role::create([
            'role_name' => 'admin',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
        $role = Role::create([
            'role_name' => 'user',
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);
    }
}
