<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AircraftFlightMaintenanceLog;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AircraftFlightMaintenanceLogController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AircraftFlightMaintenanceLog::class,'afml');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AircraftFlightMaintenanceLog::with(['aircraft_configuration',
                                                    'pre_flight_check_nearest_airport',
                                                    'pre_flight_check_person',
                                                    'post_flight_check_nearest_airport',
                                                    'pre_flight_check_person']);

            return Datatables::of($data)
                ->addColumn('aircraft_type_name', function($row) {
                    if ($row->aircraft_configuration_id){
                        return $row->aircraft_configuration->aircraft_type->name;
                    } 
                    else {
                        return '-';
                    }
                })
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
                    $approvable = false;
                    $approveId = null;

                    if ($row->approvals()->count() > 0) {
                        return '<p class="text-muted">Already Approved</p>';
                    }
                    else {
                        if(Auth::user()->can('update', AircraftFlightMaintenanceLog::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('delete', AircraftFlightMaintenanceLog::class)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('approval', AircraftFlightMaintenanceLog::class)) {
                            $approvable = true;
                            $approveId = $row->id;
                            $noAuthorize = false;
                        }
                        
                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId', 'approvable', 'approveId']));
                        }
                        else {
                            return '<p class="text-muted">Not Authorized</p>';
                        }
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('flightoperations::pages.afml.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_number' => ['required', 'max:30', 'unique:aircraft_flight_maintenance_logs,aircraft_configuration_id'],
            'transaction_date' => ['required', 'max:30'],
            'aircraft_configuration_id' => ['required', 'max:30', 'unique:aircraft_flight_maintenance_logs,page_number'],
        ]);

        $status = 1;

        $transaction_date = $request->transaction_date;
        $pre_flight_check_date = $request->pre_flight_check_date;
        $post_flight_check_date = $request->post_flight_check_date;
        
        DB::beginTransaction();
        $AircraftFlightMaintenanceLog = AircraftFlightMaintenanceLog::create([
            'uuid' =>  Str::uuid(),

            'page_number' => $request->page_number,
            'previous_page_number' => $request->previous_page_number,
            'transaction_date' => $transaction_date,
            'aircraft_configuration_id' => $request->aircraft_configuration_id,
            'last_inspection' => $request->last_inspection,
            'next_inspection' => $request->next_inspection,

            'pre_flight_check_date' => $pre_flight_check_date,
            'pre_flight_check_place' => $request->pre_flight_check_place,
            'pre_flight_check_nearest_airport_id' => $request->pre_flight_check_nearest_airport_id,
            'pre_flight_check_person_id' => $request->pre_flight_check_person_id,
            'pre_flight_check_compressor_wash' => $request->pre_flight_check_compressor_wash,

            'post_flight_check_date' => $post_flight_check_date,
            'post_flight_check_place' => $request->post_flight_check_place,
            'post_flight_check_nearest_airport_id' => $request->post_flight_check_nearest_airport_id,
            'post_flight_check_person_id' => $request->post_flight_check_person_id,
            'post_flight_check_compressor_wash' => $request->post_flight_check_compressor_wash,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        DB::commit();

        return response()->json(['success' => 'Aircraft Flight and Maintenance Log Data has been Saved',
                                    'id' => $AircraftFlightMaintenanceLog->id]);
    
    }

    public function show(AircraftFlightMaintenanceLog $afml)
    {
        return view('flightoperations::pages.afml.show', compact('afml'));
    }

    public function update(Request $request, AircraftFlightMaintenanceLog $afml)
    {
        $currentRow = AircraftFlightMaintenanceLog::where('id', $afml->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'page_number' => ['required', 'max:30', 'unique:aircraft_flight_maintenance_logs,aircraft_configuration_id'],
                'transaction_date' => ['required', 'max:30'],
                'aircraft_configuration_id' => ['required', 'max:30', 'unique:aircraft_flight_maintenance_logs,page_number'],
            ]);
    
            $status = 1;
    
            $transaction_date = $request->transaction_date;
            $pre_flight_check_date = $request->pre_flight_check_date;
            $post_flight_check_date = $request->post_flight_check_date;
            
            DB::beginTransaction();
            $currentRow->update([
                'page_number' => $request->page_number,
                'previous_page_number' => $request->previous_page_number,
                'transaction_date' => $transaction_date,
                'aircraft_configuration_id' => $request->aircraft_configuration_id,
                'last_inspection' => $request->last_inspection,
                'next_inspection' => $request->next_inspection,
    
                'pre_flight_check_date' => $pre_flight_check_date,
                'pre_flight_check_place' => $request->pre_flight_check_place,
                'pre_flight_check_nearest_airport_id' => $request->pre_flight_check_nearest_airport_id,
                'pre_flight_check_person_id' => $request->pre_flight_check_person_id,
                'pre_flight_check_compressor_wash' => $request->pre_flight_check_compressor_wash,
    
                'post_flight_check_date' => $post_flight_check_date,
                'post_flight_check_place' => $request->post_flight_check_place,
                'post_flight_check_nearest_airport_id' => $request->post_flight_check_nearest_airport_id,
                'post_flight_check_person_id' => $request->post_flight_check_person_id,
                'post_flight_check_compressor_wash' => $request->post_flight_check_compressor_wash,
    
                'status' => $status,
                'updated_by' => $request->user()->id,
            ]);
            DB::commit();

            return response()->json(['success' => 'Aircraft Configuration Data has been Updated',
                                    'id' => $currentRow->id]);
        }
        else {
            return response()->json(['error' => "This Aircraft Flight & Maintenance Log and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(AircraftFlightMaintenanceLog $afml)
    {
        $currentRow = AircraftFlightMaintenanceLog::where('id', $afml->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        AircraftFlightMaintenanceLog::destroy($afml->id);
        return response()->json(['success' => 'Aircraft Flight & Maintenance Log Data has been Deleted']);
    }

    // public function select2(Request $request)
    // {
    //     $search = $request->q;

    //     $query = AircraftType::orderby('name','asc')
    //                 ->select('id','name')
    //                 ->where('status', 1);

    //     if($search != ''){
    //         $query = $query->where('name', 'like', '%' .$search. '%');
    //     }
    //     $AircraftTypes = $query->get();

    //     $response = [];
    //     foreach($AircraftTypes as $AircraftType){
    //         $response['results'][] = [
    //             "id"=>$AircraftType->id,
    //             "text"=>$AircraftType->name
    //         ];
    //     }

    //     return response()->json($response);
    // }
}