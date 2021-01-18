<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\Airport;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AirportController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Airport::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Airport::all();
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    if(Auth::user()->can('update', Airport::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Airport::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted">Not Authorized</p>';
                    }
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('generalsetting::pages.airport.index');
    }

    public function create()
    {
        return view('generalsetting::pages.airport.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ident' => ['required', 'max:30', 'unique:airports,ident'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Airport::create([
            'ident' => $request->ident,
            'type' => $request->type,
            'name' => $request->name, 
            'latitude_deg' => $request->latitude_deg, 
            'longitude_deg' => $request->longitude_deg, 
            'elevation_ft' => $request->elevation_ft, 
            'continent' => $request->continent, 
            'iso_country' => $request->iso_country, 
            'iso_region' => $request->iso_region, 
            'municipality' => $request->municipality, 
            'scheduled_service' => $request->scheduled_service, 
            'gps_code' => $request->gps_code, 
            'iata_code' => $request->iata_code, 
            'local_code' => $request->local_code, 
            'home_link' => $request->home_link, 
            'wikipedia_link' => $request->wikipedia_link, 
            'keywords' => $request->keywords,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Airport Data has been Added']);
    
    }

    public function show(Airport $Airport)
    {
        return view('generalsetting::pages.airport.show');
    }

    public function edit(Airport $Airport)
    {
        return view('generalsetting::pages.airport.edit', compact('Airport'));
    }

    public function update(Request $request, Airport $Airport)
    {
        $request->validate([
            'ident' => ['required', 'max:30', 'unique:airports,ident'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = Airport::where('id', $Airport->id)->first();
        if ( $currentRow->ident == $request->ident) {
            $currentRow
                ->update([
                    'type' => $request->type,
                    'name' => $request->name, 
                    'latitude_deg' => $request->latitude_deg, 
                    'longitude_deg' => $request->longitude_deg, 
                    'elevation_ft' => $request->elevation_ft, 
                    'continent' => $request->continent, 
                    'iso_country' => $request->iso_country, 
                    'iso_region' => $request->iso_region, 
                    'municipality' => $request->municipality, 
                    'scheduled_service' => $request->scheduled_service, 
                    'gps_code' => $request->gps_code, 
                    'iata_code' => $request->iata_code, 
                    'local_code' => $request->local_code, 
                    'home_link' => $request->home_link, 
                    'wikipedia_link' => $request->wikipedia_link, 
                    'keywords' => $request->keywords,
                    'description' => $request->description,
                    'manufacturer_id' => $request->manufacturer_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $currentRow
                ->update([
                    'ident' => $request->ident,
                    'type' => $request->type,
                    'name' => $request->name, 
                    'latitude_deg' => $request->latitude_deg, 
                    'longitude_deg' => $request->longitude_deg, 
                    'elevation_ft' => $request->elevation_ft, 
                    'continent' => $request->continent, 
                    'iso_country' => $request->iso_country, 
                    'iso_region' => $request->iso_region, 
                    'municipality' => $request->municipality, 
                    'scheduled_service' => $request->scheduled_service, 
                    'gps_code' => $request->gps_code, 
                    'iata_code' => $request->iata_code, 
                    'local_code' => $request->local_code, 
                    'home_link' => $request->home_link, 
                    'wikipedia_link' => $request->wikipedia_link, 
                    'keywords' => $request->keywords,
                    'description' => $request->description,
                    'manufacturer_id' => $request->manufacturer_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        
        return response()->json(['success' => 'Airport Data has been Updated']);
    
    }

    public function destroy(Airport $Airport)
    {
        $currentRow = Airport::where('id', $Airport->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Airport::destroy($Airport->id);
        return response()->json(['success' => 'Contact Data has been Deleted']);
    }

}