<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailJournal;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

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
        $afm_log_id = $request->id;
        
        $data = AfmlDetailJournal::where('afm_log_id', $afm_log_id)
                            ->with(['from_airport:id,iata_code,name',
                                    'to_airport:id,iata_code,name'])
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

                if(Auth::user()->can('update', AfmlDetailJournal::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', AfmlDetailJournal::class)) {
                    $deleteable = true;
                    $deleteButtonClass = 'deleteButtonJournal';
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
                'route_from' => 'required',
                'route_to' => 'required',
                'block_off' => 'required',
                'take_off' => 'required | after:block_off',
                'landing' => 'required | after:take_off',
                'block_on' => 'required | after:landing',
            ]);
    
            // if ($request->status) {
            //     $status = 1;
            // } 
            // else {
            //     $status = 0;
            // }

            $take_off = Carbon::parse($request->take_off);
            $landing = Carbon::parse($request->landing);
            $sub_total_flight_hour = gmdate('H:i', $landing->diffInSeconds($take_off));

            $block_off = Carbon::parse($request->block_off);
            $block_on = Carbon::parse($request->block_on);
            $sub_total_block_hour = gmdate('H:i', $block_on->diffInSeconds($block_off));
    
            AfmlDetailJournal::create([
                'uuid' =>  Str::uuid(),
    
                'afm_log_id' => $request->afm_log_id,
                'route_from' => $request->route_from,
                'route_to' => $request->route_to,
                'block_off' => $request->block_off,
                'take_off' => $request->take_off,
                'landing' => $request->landing,
                'block_on' => $request->block_on,

                'sub_total_flight_hour' => $sub_total_flight_hour,
                'sub_total_block_hour' => $sub_total_block_hour,
                'sub_total_cycle' => 1,
                'sub_total_event' => $request->sub_total_event,

                'description' => $request->journal_description,

                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => $request->user()->id,
            ]);

            Self::calculateTotalAging($AfmLog);
    
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

        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

        if ($AfmLog->approvals()->count() == 0) {
            $request->validate([
                'route_from' => 'required',
                'route_to' => 'required',
                'block_off' => 'required',
                'take_off' => 'required | after:block_off',
                'landing' => 'required | after:take_off',
                'block_on' => 'required | after:landing',
            ]);
    
            // if ($request->status) {
            //     $status = 1; 
            // } 
            // else {
            //     $status = 0;
            // }

            $take_off = Carbon::parse($request->take_off);
            $landing = Carbon::parse($request->landing);
            $sub_total_flight_hour = gmdate('H:i', $landing->diffInSeconds($take_off));

            $block_off = Carbon::parse($request->block_off);
            $block_on = Carbon::parse($request->block_on);
            $sub_total_block_hour = gmdate('H:i', $block_on->diffInSeconds($block_off));
            
            $currentRow
                ->update([
                    'route_from' => $request->route_from,
                    'route_to' => $request->route_to,
                    'block_off' => $request->block_off,
                    'take_off' => $request->take_off,
                    'landing' => $request->landing,
                    'block_on' => $request->block_on,
                    
                    'sub_total_flight_hour' => $sub_total_flight_hour,
                    'sub_total_block_hour' => $sub_total_block_hour,
                    'sub_total_cycle' => 1,
                    'sub_total_event' => $request->sub_total_event,

                    'description' => $request->journal_description,
    
                    'status' => 1,
                    'updated_by' => Auth::user()->id,
            ]);

            Self::calculateTotalAging($AfmLog);
            
            return response()->json(['success' => 'Journal Data has been Updated']);
        }
        else {
            return response()->json(['error' => "This AFML and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public static function calculateTotalAging(AfmLog $AfmLog)
    {
        $AfmlDetailJournal = AfmlDetailJournal::where('afm_log_id', $AfmLog->id)
                            ->select(DB::raw("SUM(TIME_TO_SEC(sub_total_flight_hour)), SUM(TIME_TO_SEC(sub_total_block_hour)), SUM(sub_total_cycle), SUM(sub_total_event)"))
                            ->get();
        
        $total_fh = $AfmlDetailJournal[0]['SUM(TIME_TO_SEC(sub_total_flight_hour))'] / 3600; 
        $total_bh = $AfmlDetailJournal[0]['SUM(TIME_TO_SEC(sub_total_block_hour))'] / 3600;
        $total_cycle = $AfmlDetailJournal[0]['SUM(sub_total_cycle)'];
        $total_event = $AfmlDetailJournal[0]['SUM(sub_total_event)'];

        DB::beginTransaction();
        $AfmLog->update([
            'total_flight_hour' => $total_fh,
            'total_block_hour' => $total_bh,
            'total_flight_cycle' => $total_cycle,
            'total_flight_event' => $total_event,
        ]);
        DB::commit();
    }

    public function destroy(AfmlDetailJournal $AfmlDetailJournal)
    {
        $currentRow = AfmlDetailJournal::where('id', $AfmlDetailJournal->id)->first();
        $AfmLog = AfmLog::where('id', $currentRow->afm_log_id)->first();

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