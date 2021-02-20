<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailRectification;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AfmlDetailRectificationController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AfmlDetailRectification::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $afm_log_id = $request->id;
        
        $data = AfmlDetailRectification::where('afm_log_id', $afm_log_id)
                                        ->with(['afml_detail_discrepancy',
                                                'employee:id,fullname'])
                                        ->get();
                                                
        $AfmLog = AfmLog::where('id', $afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            return Datatables::of($data)
            // ->addColumn('status', function($row){
            //     if ($row->status == 1){
            //         return '<label class="label label-success">Active</label>';
            //     } else{
            //         return '<label class="label label-danger">Inactive</label>';
            //     }
            // })
            
            ->addColumn('creator_name', function($row){
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row){
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $noAuthorize = true;

                if(Auth::user()->can('update', AfmlDetailRectification::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AfmlDetailRectification::class)) {
                    $deleteable = true;
                    $deleteButtonClass = 'deleteButtonManifest';
                    $deleteId = $row->id;
                    $noAuthorize = false;
                }

                if ($noAuthorize == false) {
                    return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteButtonClass', 'deleteId']));
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
            // ->addColumn('status', function($row){
            //     if ($row->status == 1){
            //         return '<label class="label label-success">Active</label>';
            //     } else{
            //         return '<label class="label label-danger">Inactive</label>';
            //     }
            // })
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
        $AfmLog = AfmLog::where('id', $request->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'rectification_title' => 'required',
                'rectification_description' => 'required',
            ]);
    
            // if ($request->status) {
            //     $status = 1;
            // } 
            // else {
            //     $status = 0;
            // }
    
            DB::beginTransaction();
            $AfmlDetailRectification = AfmlDetailRectification::create([
                'uuid' =>  Str::uuid(),
    
                'afm_log_id' => $request->afm_log_id,
                'afml_detail_discrepancy_id' => $request->afml_detail_discrepancy_id,
                'title' => $request->rectification_title,
                'description' => $request->rectification_description,
                'performed_by' => $request->performed_by,

                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $AfmlDetailRectification->update([
                'code' => 'R/' . $AfmlDetailRectification->afm_log_id . '/' . $AfmlDetailRectification->id,
            ]);
            DB::commit();
    
            return response()->json(['success' => 'Rectification Data has been Added']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, AfmlDetailRectification $AfmlDetailRectification)
    {
        $currentRow = AfmlDetailRectification::where('id', $AfmlDetailRectification->id)
                                                ->first();

        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'rectification_title' => 'required',
                'rectification_description' => 'required',
            ]);
    
            // if ($request->status) {
            //     $status = 1; 
            // } 
            // else {
            //     $status = 0;
            // }
            
            $currentRow
                ->update([
                    'afml_detail_discrepancy_id' => $request->afml_detail_discrepancy_id,
                    'title' => $request->rectification_title,
                    'description' => $request->rectification_description,
                    'performed_by' => $request->performed_by,
    
                    'status' => 1,
                    'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Rectification Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(AfmlDetailRectification $AfmlDetailRectification)
    {
        $currentRow = AfmlDetailRectification::where('id', $AfmlDetailRectification->id)->first();
        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);

            AfmlDetailRectification::destroy($AfmlDetailRectification->id);
            return response()->json(['success' => 'Rectification Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}