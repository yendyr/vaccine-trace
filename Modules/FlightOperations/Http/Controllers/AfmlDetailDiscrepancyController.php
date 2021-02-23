<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailDiscrepancy;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AfmlDetailDiscrepancyController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AfmlDetailDiscrepancy::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $afm_log_id = $request->id;
        
        $data = AfmlDetailDiscrepancy::where('afm_log_id', $afm_log_id)
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
            // ->addColumn('progress_status', function($row){
            //     if ($row->status == 1){
            //         return '<label class="label label-danger">Open</label>';
            //     } else{
            //         return '<label class="label label-success">Closed</label>';
            //     }
            // })
            ->addColumn('rectification_code', function($row) {
                if ($row->rectification_details()->count() == 0) {
                    return '<p class="text-info">No Related Rectification Performed</p>';
                } 
                else {
                    $rectification_code = null;

                    foreach ($row->rectification_details as $rectification_detail) {
                        $rectification_code .= '<label class="label label-success m-r-xs">' . $rectification_detail->code . '</label>';
                    }

                    return $rectification_code;
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

                if(Auth::user()->can('update', AfmlDetailDiscrepancy::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AfmlDetailDiscrepancy::class)) {
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
                return '<p class="text-muted font-italic">Already Approved</p>';
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
                'title' => 'required',
                'discrepancy_description' => 'required',
            ]);
    
            // if ($request->status) {
            //     $status = 1;
            // } 
            // else {
            //     $status = 0;
            // }
    
            DB::beginTransaction();
            $AfmlDetailDiscrepancy = AfmlDetailDiscrepancy::create([
                'uuid' =>  Str::uuid(),
    
                'afm_log_id' => $request->afm_log_id,
                'title' => $request->title,
                'description' => $request->discrepancy_description,
                'progress_status' => 0,

                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
            $AfmlDetailDiscrepancy->update([
                'code' => 'D/' . $AfmlDetailDiscrepancy->afm_log_id . '/' . $AfmlDetailDiscrepancy->id,
            ]);
            DB::commit();
    
            return response()->json(['success' => 'Discrepancy Data has been Added']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, AfmlDetailDiscrepancy $AfmlDetailDiscrepancy)
    {
        $currentRow = AfmlDetailDiscrepancy::where('id', $AfmlDetailDiscrepancy->id)
                                                ->first();

        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'title' => 'required',
                'discrepancy_description' => 'required',
            ]);
    
            // if ($request->status) {
            //     $status = 1; 
            // } 
            // else {
            //     $status = 0;
            // }
            
            $currentRow
                ->update([
                    'title' => $request->title,
                    'description' => $request->discrepancy_description,
    
                    'status' => 1,
                    'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Discrepancy Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(AfmlDetailDiscrepancy $AfmlDetailDiscrepancy)
    {
        $currentRow = AfmlDetailDiscrepancy::where('id', $AfmlDetailDiscrepancy->id)->first();
        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);

            AfmlDetailDiscrepancy::destroy($AfmlDetailDiscrepancy->id);
            return response()->json(['success' => 'Discrepancy Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function select2(Request $request)
    {
        $search = $request->term;
        $afm_log_id = $request->afm_log_id;

        $query = AfmlDetailDiscrepancy::where('afm_log_id', $afm_log_id)
                        ->where('status', 1);

        if($search != ''){
            $query = $query->where('title', 'like', '%' .$search. '%')
                        ->orWhere('description', 'like', '%' .$search. '%');
        }
        $AfmlDetailDiscrepancies = $query->get();

        $response = [];
        foreach($AfmlDetailDiscrepancies as $AfmlDetailDiscrepancy){
            $response['results'][] = [
                "id" => $AfmlDetailDiscrepancy->id,
                "text" => $AfmlDetailDiscrepancy->code . ' | ' . $AfmlDetailDiscrepancy->title . ' | ' . $AfmlDetailDiscrepancy->description
            ];
        }
        return response()->json($response);
    }
}