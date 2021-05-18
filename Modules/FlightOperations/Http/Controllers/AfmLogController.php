<?php

namespace Modules\FlightOperations\Http\Controllers;

use Modules\FlightOperations\Entities\AfmLog;
use Modules\FlightOperations\Entities\AfmlDetailJournal;
use Modules\FlightOperations\Entities\AfmlApproval;
use Modules\PPC\Entities\AircraftConfiguration;
use Modules\SupplyChain\Entities\ItemStock;
use Modules\PPC\Entities\ItemStockAging;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class AfmLogController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(AfmLog::class, 'afmlog');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AfmLog::with(['aircraft_configuration',
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
                        return '<p class="text-muted font-italic">Already Approved</p>';
                    }
                    else {
                        if(Auth::user()->can('update', AfmLog::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('delete', AfmLog::class)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('approval', AfmLog::class)) {
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

        return view('flightoperations::pages.afmlog.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_number' => ['required', 'max:30', 'unique:afm_logs,aircraft_configuration_id'],
            'transaction_date' => ['required', 'max:30'],
            'aircraft_configuration_id' => ['required', 'max:30', 'unique:afm_logs,page_number'],
        ]);

        $status = 1;

        $transaction_date = $request->transaction_date;
        $pre_flight_check_date = $request->pre_flight_check_date;
        $post_flight_check_date = $request->post_flight_check_date;
        
        DB::beginTransaction();
        $AfmLog = AfmLog::create([
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
                                    'id' => $AfmLog->id]);
    
    }

    public function show(AfmLog $afmlog)
    {
        return view('flightoperations::pages.afmlog.show', compact('afmlog'));
    }

    public function update(Request $request, AfmLog $afmlog)
    {
        $currentRow = AfmLog::where('id', $afmlog->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'page_number' => ['required', 'max:30', 'unique:afm_logs,aircraft_configuration_id'],
                'transaction_date' => ['required', 'max:30'],
                'aircraft_configuration_id' => ['required', 'max:30', 'unique:afm_logs,page_number'],
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

    public function destroy(AfmLog $afmlog)
    {
        $currentRow = AfmLog::where('id', $afmlog->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        AfmLog::destroy($afmlog->id);
        return response()->json(['success' => 'Aircraft Flight & Maintenance Log Data has been Deleted']);
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

    public function approve(Request $request, AfmLog $afmlog)
    {
        $request->validate([
            'approval_notes' => ['required', 'max:30'],
        ]);

        $AircraftConfiguration = AircraftConfiguration::where('id', $afmlog->aircraft_configuration_id)
                                                    ->where('status', 1)
                                                    ->first();
        $ItemLists = ItemStock::where('warehouse_id', $AircraftConfiguration->warehouse->id)
                                ->where('status', 1)
                                ->get();

        Self::calculateTotalAging($afmlog);

        DB::beginTransaction();
        AfmlApproval::create([
            'uuid' =>  Str::uuid(),

            'afm_log_id' =>  $afmlog->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);

        $afmlog->item_stock_aging_details()->forceDelete();

        foreach($ItemLists as $item) {
            ItemStockAging::create([
                'uuid' =>  Str::uuid(),

                'item_stock_id' => $item->id,
                'transaction_reference_id' => $afmlog->id,
                'transaction_reference_class' => 'Modules\FlightOperations\Entities\AfmLog',
                'transaction_reference_text' => 'Aircraft Flight & Maintenance Log',
                'transaction_reference_url' => 'flightoperations/afmlog',

                'flight_hour' => $afmlog->total_flight_hour,
                'block_hour' => $afmlog->total_block_hour,
                'flight_cycle' => $afmlog->total_flight_cycle,
                'flight_event' => $afmlog->total_flight_event,
        
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
        }
        DB::commit();

        return response()->json(['success' => 'Aircraft Flight & Maintenance Log Data has been Approved']);
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