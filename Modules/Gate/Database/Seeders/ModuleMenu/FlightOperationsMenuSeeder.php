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

        $menu = Menu::create([
            'menu_link' => 'flightoperations/flight-log',
            'menu_text' => 'Aircraft Flight Log',
            'menu_route' => 'flightoperations.flight-log.index',
            'menu_icon' => 'fa-location-arrow',
            'menu_class' => 'Modules\FlightOperations\Entities\FlightLog',
            'menu_id' => null,
            'menu_actives' => json_encode(['flightoperations/flight-log', 'flightoperations/flight-log/*']),
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

        $menu = Menu::create([
            'menu_link' => 'flightoperations/maintenance-log',
            'menu_text' => 'Aircraft Maintenance Log',
            'menu_route' => 'flightoperations.maintenance-log.index',
            'menu_icon' => 'fa-steam',
            'menu_class' => 'Modules\FlightOperations\Entities\MaintenanceLog',
            'menu_id' => null,
            'menu_actives' => json_encode(['flightoperations/maintenance-log', 'flightoperations/maintenance-log/*']),
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
    }
}