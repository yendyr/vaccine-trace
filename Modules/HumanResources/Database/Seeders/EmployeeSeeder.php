<?php

namespace Modules\HumanResources\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\HumanResources\Entities\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Employee::create([
           'empid' => '001',
           'fullname' => 'Subagiyo Hong',
           'status' => 1,
           'uuid' => Str::uuid(),
       ]); 
        Employee::create([
           'empid' => '002',
           'fullname' => 'Ali Muhammad',
           'status' => 1,
           'uuid' => Str::uuid(),
       ]); 
        Employee::create([
           'empid' => '003',
           'fullname' => 'Ong Lu Ya',
           'status' => 1,
           'uuid' => Str::uuid(),
       ]); 
        Employee::create([
           'empid' => '004',
           'fullname' => 'Hong Ti',
           'status' => 1,
           'uuid' => Str::uuid(),
       ]); 
        Employee::create([
           'empid' => '005',
           'fullname' => 'Heng Tho',
           'status' => 1,
           'uuid' => Str::uuid(),
       ]); 
    }
}
