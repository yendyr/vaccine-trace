<?php

namespace Modules\Gate\Database\Seeders\ModuleMenu;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Gate\Entities\Menu;

class FlightOperationsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $settingMenu = Menu::create([
            'menu_link' => '#',
            'menu_text' => 'Setting',
            'menu_route' => null,
            'menu_icon' => 'fa-wrench',
            'menu_class' => null,
            'menu_id' => null,
            'group' => 'Flight Operations',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);
        
        Menu::create([
            'menu_link' => 'flightoperations/in-flight-role',
            'menu_text' => 'In-Flight Role',
            'menu_route' => 'flightoperations.in-flight-role.index',
            'menu_icon' => 'fa-address-book',
            'menu_class' => 'Modules\Gate\Entities\Role',
            'menu_id' => null,
            'menu_actives' => json_encode(['flightoperations/in-flight-role', 'flightoperations/in-flight-role/*']),
            'group' => 'Flight Operations',
            'add' => 1,
            'update' => 1,
            'delete' => 0,
            'print' => 0,
            'approval' => 0,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => $settingMenu->id
        ]);

        $menu = Menu::create([
            'menu_link' => 'flightoperations/afml',
            'menu_text' => 'Aircraft Flight & Maintenance Log',
            'menu_route' => 'flightoperations.afml.index',
            'menu_icon' => 'fa-location-arrow',
            'menu_class' => 'Modules\FlightOperations\Entities\AircraftFlightMaintenanceLog',
            'menu_id' => null,
            'menu_actives' => json_encode(['flightoperations/afml', 'flightoperations/afml/*']),
            'group' => 'Flight Operations',
            'add' => 1,
            'update' => 1,
            'delete' => 1,
            'print' => 1,
            'approval' => 1,
            'process' => 0,
            'status' => 1,
            'uuid' => Str::uuid(),
            'parent_id' => null
        ]);

        // $menu = Menu::create([
        //     'menu_link' => 'flightoperations/flight-log',
        //     'menu_text' => 'Aircraft Flight Log',
        //     'menu_route' => 'flightoperations.flight-log.index',
        //     'menu_icon' => 'fa-location-arrow',
        //     'menu_class' => 'Modules\FlightOperations\Entities\FlightLog',
        //     'menu_id' => null,
        //     'menu_actives' => json_encode(['flightoperations/flight-log', 'flightoperations/flight-log/*']),
        //     'group' => 'Flight Operations',
        //     'add' => 1,
        //     'update' => 1,
        //     'delete' => 1,
        //     'print' => 1,
        //     'approval' => 1,
        //     'process' => 0,
        //     'status' => 1,
        //     'uuid' => Str::uuid(),
        //     'parent_id' => null
        // ]);

        // $menu = Menu::create([
        //     'menu_link' => 'flightoperations/maintenance-log',
        //     'menu_text' => 'Aircraft Maintenance Log',
        //     'menu_route' => 'flightoperations.maintenance-log.index',
        //     'menu_icon' => 'fa-steam',
        //     'menu_class' => 'Modules\FlightOperations\Entities\MaintenanceLog',
        //     'menu_id' => null,
        //     'menu_actives' => json_encode(['flightoperations/maintenance-log', 'flightoperations/maintenance-log/*']),
        //     'group' => 'Flight Operations',
        //     'add' => 1,
        //     'update' => 1,
        //     'delete' => 1,
        //     'print' => 1,
        //     'approval' => 1,
        //     'process' => 0,
        //     'status' => 1,
        //     'uuid' => Str::uuid(),
        //     'parent_id' => null
        // ]);
    }
}