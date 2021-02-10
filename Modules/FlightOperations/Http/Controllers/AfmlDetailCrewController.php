<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailCrew;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AfmlDetailCrewController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AfmlDetailCrew::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $afm_logs_id = $request->id;
        
        $data = AfmlDetailCrew::where('afm_logs_id', $afm_logs_id)
                            ->with(['employee:id,fullname',
                                    'in_flight_role:id,role_name,role_name_alias'])
                            ->get();
                                                
        $AfmLog = AfmLog::where('id', $afm_logs_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
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
            ->addColumn('action', function($row) {
                $noAuthorize = true;

                if(Auth::user()->can('update', AfmlDetailCrew::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AfmlDetailCrew::class)) {
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
        else {
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
            ->addColumn('action', function($row) {
                return '<p class="text-muted">Already Approved</p>';
            })
            ->escapeColumns([])
            ->make(true);
        }
    }

    public function store(Request $request)
    {
        $AfmLog = AfmLog::where('id', $request->afm_logs_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'employee_id' => ['required'],
                'role_id' => ['required'],
            ]);
    
            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }
    
            $AfmlDetailCrew = AfmlDetailCrew::create([
                'uuid' =>  Str::uuid(),
    
                'afm_logs_id' => $request->afm_logs_id,
                'employee_id' => $request->employee_id,
                'role_id' => $request->role_id,
                'description' => $request->description,

                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
    
            return response()->json(['success' => 'Crew Data has been Added']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, AfmlDetailCrew $AfmlDetailCrew)
    {
        $currentRow = AfmlDetailCrew::where('id', $AfmlDetailCrew->id)
                                                ->first();

        $AfmLog = AfmLog::where('id', $currentRow->afm_logs_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'employee_id' => ['required'],
                'role_id' => ['required'],
            ]);
    
            if ($request->status) {
                $status = 1; 
            } 
            else {
                $status = 0;
            }
            
            $currentRow
                ->update([
                    'afm_logs_id' => $request->afm_logs_id,
                    'employee_id' => $request->employee_id,
                    'role_id' => $request->role_id,
                    'description' => $request->description,
    
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Crew Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(AfmlDetailCrew $AfmlDetailCrew)
    {
        $currentRow = AfmlDetailCrew::where('id', $AfmlDetailCrew->id)->first();
        $AfmLog = AfmLog::where('id', $currentRow->afm_logs_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);

            AfmlDetailCrew::destroy($AfmlDetailCrew->id);
            return response()->json(['success' => 'Crew Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}