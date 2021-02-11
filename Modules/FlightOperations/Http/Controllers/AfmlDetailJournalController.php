<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailJournal;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AfmlDetailJournalController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AfmlDetailJournal::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $afm_logs_id = $request->id;
        
        $data = AfmlDetailJournal::where('afm_logs_id', $afm_logs_id)
                            ->with(['route_from:id,iata_code,name',
                                    'route_to:id,iata_code,name'])
                            ->get();
                                                
        $AfmLog = AfmLog::where('id', $afm_logs_id)->first();

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

                if(Auth::user()->can('update', AfmlDetailJournal::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AfmlDetailJournal::class)) {
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
                'route_from' => 'required',
                'route_to' => 'required',
                'block_off' => 'required',
                'take_off' => 'required | after:block_off',
                'landing' => 'required | after:take_off',
                'block_on' => 'required | after:landing',
            ]);
    
            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }
    
            AfmlDetailJournal::create([
                'uuid' =>  Str::uuid(),
    
                'afm_logs_id' => $request->afm_logs_id,
                'route_from' => $request->route_from,
                'route_to' => $request->route_to,
                'block_off' => $request->block_off,
                'take_off' => $request->take_off,
                'landing' => $request->landing,
                'block_on' => $request->block_on,
                'sub_total_cycle' => 1,
                'sub_total_event' => $request->sub_total_event,
                'description' => $request->description,

                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);
    
            return response()->json(['success' => 'Journal Data has been Added']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, AfmlDetailJournal $AfmlDetailJournal)
    {
        $currentRow = AfmlDetailJournal::where('id', $AfmlDetailJournal->id)
                                                ->first();

        $AfmLog = AfmLog::where('id', $currentRow->afm_logs_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'route_from' => 'required',
                'route_to' => 'required',
                'block_off' => 'required',
                'take_off' => 'required | after:block_off',
                'landing' => 'required | after:take_off',
                'block_on' => 'required | after:landing',
            ]);
    
            if ($request->status) {
                $status = 1; 
            } 
            else {
                $status = 0;
            }
            
            $currentRow
                ->update([
                    'route_from' => $request->route_from,
                    'route_to' => $request->route_to,
                    'block_off' => $request->block_off,
                    'take_off' => $request->take_off,
                    'landing' => $request->landing,
                    'block_on' => $request->block_on,
                    'sub_total_cycle' => 1,
                    'sub_total_event' => $request->sub_total_event,
                    'description' => $request->description,
    
                    'status' => 1,
                    'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Journal Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(AfmlDetailJournal $AfmlDetailJournal)
    {
        $currentRow = AfmlDetailJournal::where('id', $AfmlDetailJournal->id)->first();
        $AfmLog = AfmLog::where('id', $currentRow->afm_logs_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);

            AfmlDetailJournal::destroy($AfmlDetailJournal->id);
            return response()->json(['success' => 'Journal Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}