<?php
namespace Modules\GeneralSetting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\GeneralSetting\Database\Repositories\AirportRepository;
use Modules\GeneralSetting\Database\Repositories\AirportParam;

class AirportsTableSeeder extends Seeder
{
    public function run(AirportRepository $airportRepository, AirportParam $airportParam)
    {
        $file = __DIR__ . '/../Repositories/Airports.csv';
        
        $header = array(
                        'id', 
                        'ident', 
                        'type', 
                        'name', 
                        'latitude_deg', 
                        'longitude_deg', 
                        'elevation_ft', 
                        'continent', 
                        'iso_country', 
                        'iso_region', 
                        'municipality', 
                        'scheduled_service', 
                        'gps_code', 
                        'iata_code', 
                        'local_code', 
                        'home_link', 
                        'wikipedia_link', 
                        'keywords'
                    );

        $delimiter = ',';
        if (file_exists($file) || is_readable($file)) {

            if (($handle = fopen($file, 'r')) !== false) {
                ini_set('memory_limit', -1);
                DB::disableQueryLog();
                DB::beginTransaction();
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    $data = array_combine($header, $row);
                    if ($data['id'] != 'id') {

                        // if ($data['elevation_ft'] == '') {
                        //     $data['elevation_ft'] = 0;
                        // }

                        $result = $this->container->call([$airportRepository, 'getByIdent'], ['ident' => $data['ident']]);

                        // $airportParam->setId($data['id']);
                        $airportParam->setIdent($data['ident']);
                        // $airportParam->setType($data['type']);
                        $airportParam->setName($data['name']);
                        // $airportParam->setLatitudeDeg($data['latitude_deg']);
                        // $airportParam->setLongitudeDeg($data['longitude_deg']);
                        // $airportParam->setElevationFt($data['elevation_ft']);
                        $airportParam->setContinent($data['continent']);
                        $airportParam->setIsoCountry($data['iso_country']);
                        $airportParam->setIsoRegion($data['iso_region']);
                        // $airportParam->setMunicipality($data['municipality']);
                        // $airportParam->setScheduledService($data['scheduled_service']);
                        // $airportParam->setGpsCode($data['gps_code']);
                        // $airportParam->setIataCode($data['iata_code']);
                        // $airportParam->setLocalCode($data['local_code']);
                        // $airportParam->setHomeLink($data['home_link']);
                        // $airportParam->setWikipediaLink($data['wikipedia_link']);
                        // $airportParam->setKeywords($data['keywords']);

                        $this->container->call([$airportRepository, 'store'], ['airportParam' => $airportParam]);

                        // if ($result == null) {

                        //     $this->container->call([$airportRepository, 'store'], ['airportParam' => $airportParam]);
                        // } else {
                        //     $this->container->call([$airportRepository, 'updateByIdent'], ['ident' => $data['ident'], 'airportParam' => $airportParam]);
                        // }
                    }
                }
                DB::commit();
                fclose($handle);
            }
        }
    }
}