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
            $data = AircraftFlightMaintenanceLog::with(['aircraft_configuration']);

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

    public function update(Request $request, AircraftFlightMaintenanceLog $AircraftFlightMaintenanceLog)
    {
        

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $threshold_date = $request->threshold_date;
        
        $repeat_date = $request->repeat_date;
        
        $issued_date = $request->issued_date;

        DB::beginTransaction();
        $currentRow = Taskcard::where('id', $Taskcard->id)->first();
        $currentRow
            ->update([
                'mpd_number' => $request->mpd_number,
                'title' => $request->title,
                'taskcard_group_id' => $request->taskcard_group_id,
                'taskcard_type_id' => $request->taskcard_type_id,
                'compliance' => $request->compliance,
                'threshold_flight_hour' => $request->threshold_flight_hour,
                'threshold_flight_cycle' => $request->threshold_flight_cycle,
                'threshold_daily' => $request->threshold_daily,
                'threshold_daily_unit' => $request->threshold_daily_unit,
                'threshold_date' => $threshold_date,
                'repeat_flight_hour' => $request->repeat_flight_hour,
                'repeat_flight_cycle' => $request->repeat_flight_cycle,
                'repeat_daily' => $request->repeat_daily,
                'repeat_daily_unit' => $request->repeat_daily_unit,
                'repeat_date' => $repeat_date,
                'interval_control_method' => $request->interval_control_method,

                'company_number' => $request->company_number,
                'ata' => $request->ata,
                'issued_date' => $issued_date,
                'version' => $request->version,
                'revision' => $request->revision,
                'effectivity' => $request->effectivity,
                'taskcard_workarea_id' => $request->taskcard_workarea_id,
                'source' => $request->source,
                'reference' => $request->reference,
                'file_attachment' => $request->file_attachment,
                'scheduled_priority' => $request->scheduled_priority,
                'recurrence' => $request->recurrence,

                'status' => 1,
                'updated_by' => $request->user()->id,
        ]);

        if ($request->aircraft_type_id) {
            $Taskcard->aircraft_type_details()->forceDelete();

            foreach ($request->aircraft_type_id as $aircraft_type_id) {
                $Taskcard->aircraft_type_details()
                        ->save(new TaskcardDetailAircraftType([
                            'uuid' => Str::uuid(),
                            'aircraft_type_id' => $aircraft_type_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->affected_item_id) {
            foreach ($request->affected_item_id as $affected_item_id) {
                $Taskcard->affected_item_details()
                        ->save(new TaskcardDetailAffectedItem([
                            'uuid' => Str::uuid(),
                            'affected_item_id' => $affected_item_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_access_id) {
            $Taskcard->access_details()->forceDelete();

            foreach ($request->taskcard_access_id as $taskcard_access_id) {
                $Taskcard->access_details()
                        ->save(new TaskcardDetailAccess([
                            'uuid' => Str::uuid(),
                            'taskcard_access_id' => $taskcard_access_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_zone_id) {
            $Taskcard->zone_details()->forceDelete();

            foreach ($request->taskcard_zone_id as $taskcard_zone_id) {
                $Taskcard->zone_details()
                        ->save(new TaskcardDetailZone([
                            'uuid' => Str::uuid(),
                            'taskcard_zone_id' => $taskcard_zone_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_document_library_id) {
            $Taskcard->document_library_details()->forceDelete();

            foreach ($request->taskcard_document_library_id as $taskcard_document_library_id) {
                $Taskcard->document_library_details()
                        ->save(new TaskcardDetailDocumentLibrary([
                            'uuid' => Str::uuid(),
                            'taskcard_document_library_id' => $taskcard_document_library_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        if ($request->taskcard_affected_manual_id) {
            $Taskcard->affected_manual_details()->forceDelete();

            foreach ($request->taskcard_affected_manual_id as $taskcard_affected_manual_id) {
                $Taskcard->affected_manual_details()
                        ->save(new TaskcardDetailAffectedManual([
                            'uuid' => Str::uuid(),
                            'taskcard_affected_manual_id' => $taskcard_affected_manual_id,
                            'owned_by' => $request->user()->company_id,
                            'status' => 1,
                            'created_by' => $request->user()->id,
                        ]));
            }
        }

        DB::commit();

        return response()->json(['success' => 'Task Card Data has been Updated']);
    
    }

    public function destroy(Taskcard $Taskcard)
    {
        $currentRow = Taskcard::where('id', $Taskcard->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Taskcard::destroy($Taskcard->id);
        return response()->json(['success' => 'Task Card Data has been Deleted']);
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

    public function fileUpload(Request $request, Taskcard $Taskcard)
    {
        if($request->ajax()) {
            $data = $request->file('file');
            $extension = $data->getClientOriginalExtension();
            $filename = 'taskcard_attachment_' . $Taskcard->id . '.' . $extension;
            $path = public_path('uploads/company/' . $Taskcard->owned_by . '/taskcard/');
            
            $usersImage = public_path('uploads/company/' . $Taskcard->owned_by . '/taskcard/' . $filename);

            if (File::exists($usersImage)) {
                unlink($usersImage);
                $successText = 'Task Card Attachment has been Updated';
            } else {
                $successText = 'Task Card Attachment has been Updated';
            }

            Taskcard::where('id', $Taskcard->id)
                ->update([
                    'file_attachment' => $filename,
                    'updated_by' => $request->user()->id
                ]);

            $data->move($path, $filename);

            return response()->json(['success' => $successText]);
        }
    }

}