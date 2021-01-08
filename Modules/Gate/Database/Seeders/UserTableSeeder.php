<?php

namespace Modules\Gate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role_id' => 1,
            'company_id' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        $user = User::create([
            'username' => 'user1',
            'name' => 'User 1',
            'email' => 'user1@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'company_id' => 1,
            'owned_by' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

        $user = User::create([
            'username' => 'user2',
            'name' => 'User 2',
            'email' => 'user2@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
            'company_id' => 2,
            'owned_by' => 1,
            'status' => 1,
            'uuid' => Str::uuid(),
        ]);

    }
}
