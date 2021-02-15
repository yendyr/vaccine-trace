<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailManifest;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AfmlDetailManifestController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AfmlDetailManifest::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $afm_log_id = $request->id;
        
        $data = AfmlDetailManifest::where('afm_log_id', $afm_log_id)
                            ->with(['cargo_weight_unit:id,name'])
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

                if(Auth::user()->can('update', AfmlDetailManifest::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AfmlDetailManifest::class)) {
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
                'person' => 'required',
            ]);
    
            // if ($request->status) {
            //     $status = 1;
            // } 
            // else {
            //     $status = 0;
            // }
    
            AfmlDetailManifest::create([
                'uuid' =>  Str::uuid(),
    
                'afm_log_id' => $request->afm_log_id,
                'person' => $request->person,
                'pax' => $request->pax,
                'cargo_weight' => $request->cargo_weight,
                'cargo_weight_unit_id' => $request->cargo_weight_unit_id,
                'pcm_number' => $request->pcm_number,
                'cm_number' => $request->cm_number,
                'description' => $request->description,

                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
    
            return response()->json(['success' => 'Manifest Data has been Added']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, AfmlDetailManifest $AfmlDetailManifest)
    {
        $currentRow = AfmlDetailManifest::where('id', $AfmlDetailManifest->id)
                                                ->first();

        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'person' => 'required',
            ]);
    
            // if ($request->status) {
            //     $status = 1; 
            // } 
            // else {
            //     $status = 0;
            // }
            
            $currentRow
                ->update([
                    'afm_log_id' => $request->afm_log_id,
                    'person' => $request->person,
                    'pax' => $request->pax,
                    'cargo_weight' => $request->cargo_weight,
                    'cargo_weight_unit_id' => $request->cargo_weight_unit_id,
                    'pcm_number' => $request->pcm_number,
                    'cm_number' => $request->cm_number,
                    'description' => $request->description,
    
                    'status' => 1,
                    'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Manifest Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(AfmlDetailManifest $AfmlDetailManifest)
    {
        $currentRow = AfmlDetailManifest::where('id', $AfmlDetailManifest->id)->first();
        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);

            AfmlDetailManifest::destroy($AfmlDetailManifest->id);
            return response()->json(['success' => 'Manifest Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}