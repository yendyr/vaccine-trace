<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\MaintenanceProgram;
use Modules\PPC\Entities\MaintenanceProgramDetail;
use Modules\PPC\Entities\MaintenanceProgramApproval;
use Modules\PPC\Entities\Taskcard;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class MaintenanceProgramController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(MaintenanceProgram::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = MaintenanceProgram::with(['aircraft_type:id,name',
                                                'approvals:id',
                                                ]);
            
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
                    $approvable = false;
                    $approveId = null;

                    if ($row->approvals()->count() > 0) {
                        return '<p class="text-muted">Already Approved</p>';
                    }
                    else {
                        if(Auth::user()->can('update', MaintenanceProgram::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('delete', MaintenanceProgram::class)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('approval', MaintenanceProgram::class)) {
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

        return view('ppc::pages.maintenance-program.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'aircraft_type_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->duplicated_from) {
            $detail_source = MaintenanceProgram::where('id', $request->duplicated_from)
                                                ->with('maintenance_details')
                                                ->first();

            DB::beginTransaction();
            $MaintenanceProgram = MaintenanceProgram::create([
                'uuid' =>  Str::uuid(),

                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'aircraft_type_id' => $request->aircraft_type_id,

                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
            foreach ($detail_source->maintenance_details as $maintenance_detail) {
                $newDetail = MaintenanceProgramDetail::create([
                    'uuid' =>  Str::uuid(),

                    'maintenance_program_id' => $MaintenanceProgram->id,
                    'taskcard_id' => $maintenance_detail->taskcard_id,
        
                    'owned_by' => $request->user()->company_id,
                    'status' => $maintenance_detail->status,
                    'created_by' => $request->user()->id,
                ]);
            }
            DB::commit();
        }
        else {
            DB::beginTransaction();
            $MaintenanceProgram = MaintenanceProgram::create([
                'uuid' =>  Str::uuid(),

                'code' => $request->code,
                'name' => $request->name,
                'description' => $request->description,
                'aircraft_type_id' => $request->aircraft_type_id,

                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
            DB::commit();
        }

        return response()->json(['success' => 'Maintenance Program Data has been Saved',
                                'id' => $MaintenanceProgram->id]);
    }

    public function show(MaintenanceProgram $MaintenanceProgram)
    {
        return view('ppc::pages.maintenance-program.show', compact('MaintenanceProgram'));
    }

    public function update(Request $request, MaintenanceProgram $MaintenanceProgram)
    {
        $currentRow = MaintenanceProgram::where('id', $MaintenanceProgram->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'aircraft_type_id' => ['required', 'max:30'],
            ]);
    
            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }
    
            if ($currentRow->code == $request->code) {
                $currentRow
                    ->update([
                        'name' => $request->name,
                        'description' => $request->description,
                        'aircraft_type_id' => $request->aircraft_type_id,
    
                        'status' => $status,
                        'updated_by' => Auth::user()->id,
                ]);
            }
            else {
                $currentRow
                    ->update([
                        'code' => $request->code,
                        'name' => $request->name,
                        'description' => $request->description,
                        'aircraft_type_id' => $request->aircraft_type_id,
                        
                        'status' => $status,
                        'updated_by' => Auth::user()->id,
                ]);
            }
            return response()->json(['success' => 'Maintenance Program Data has been Updated',
                                    'id' => $MaintenanceProgram->id]);
        }
        else {
            return response()->json(['error' => "This Maintenance Program and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
        
    }

    public function destroy(MaintenanceProgram $MaintenanceProgram)
    {
        $currentRow = MaintenanceProgram::where('id', $MaintenanceProgram->id)->first();
        $currentRow
            ->update([
                'deleted_by' => Auth::user()->id,
            ]);

        MaintenanceProgram::destroy($MaintenanceProgram->id);
        return response()->json(['success' => 'Maintenance Program Data has been Deleted']);
    }

    public function approve(Request $request, MaintenanceProgram $MaintenanceProgram)
    {
        $request->validate([
            'approval_notes' => ['required', 'max:30'],
        ]);

        DB::beginTransaction();
        MaintenanceProgramApproval::create([
            'uuid' =>  Str::uuid(),

            'maintenance_program_id' =>  $MaintenanceProgram->id,
            'approval_notes' =>  $request->approval_notes,
    
            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => Auth::user()->id,
        ]);
        DB::commit();

        return response()->json(['success' => 'Maintenance Program Data has been Approved']);
    }

    public function select2(Request $request)
    {
        $search = $request->term;
        $aircraft_type_id = $request->aircraft_type_id;

        $query = MaintenanceProgram::where('aircraft_type_id', $aircraft_type_id)
                    // ->whereHas('approvals')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $MaintenancePrograms = $query->get();

        $response = [];
        foreach($MaintenancePrograms as $MaintenanceProgram){
            $response['results'][] = [
                "id" => $MaintenanceProgram->id,
                "text" => $MaintenanceProgram->code . ' | ' .  $MaintenanceProgram->name
            ];
        }
        return response()->json($response);
    }
}