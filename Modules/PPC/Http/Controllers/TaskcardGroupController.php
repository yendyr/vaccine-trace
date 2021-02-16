<?php

namespace Modules\PPC\Http\Controllers;

use Modules\PPC\Entities\TaskcardGroup;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TaskcardGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TaskcardGroup::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TaskcardGroup::with(['taskcard_group:id,name']);
            
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
                    if(Auth::user()->can('update', TaskcardGroup::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', TaskcardGroup::class)) {
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

        return view('ppc::pages.taskcard-group.index');
    }

    public function tree(Request $request)
    {
        $datas = TaskcardGroup::with(['taskcard_group'])
                                ->where('taskcard_groups.status', 1)
                                ->get();

        $response = [];
        foreach($datas as $data) {
            if ($data->parent_id) {
                $parent = $data->parent_id;
            }
            else {
                $parent = '#';
            }

            $response[] = [
                "id" => $data->id,
                "parent" => $parent,
                "text" => $data->name
            ];
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:taskcard_groups,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        TaskcardGroup::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->select2_parent_name,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Task Card Group Data has been Added']);
    
    }

    public function update(Request $request, TaskcardGroup $TaskcardGroup)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        $currentRow = TaskcardGroup::where('id', $TaskcardGroup->id)
                                    ->with('all_childs')
                                    ->first();

        if ($request->status) {
            $status = 1; 
            
            if ($currentRow->parent_id != null) {
                if ($currentRow->taskcard_group->status == 0) {
                    return response()->json(['error' => "This Item's Parent Status Still Deactivated, so You Can't Activate this Item"]);
                }
            }
        } 
        else {
            $status = 0;
        }

        if ($request->select2_parent_name == null || $request->select2_parent_name == 'null' || $request->select2_parent_name == '0') {
            $request->select2_parent_name = null;
        }

        DB::beginTransaction();
        if ($currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'parent_id' => $request->select2_parent_name,
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
                    'parent_id' => $request->select2_parent_name,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        if (sizeof($currentRow->all_childs) > 0) {
            Self::updateChilds($currentRow, $status);
        }
        DB::commit();
        return response()->json(['success' => 'Task Card Group Data has been Updated']);
    }

    public static function updateChilds($currentRow, $status)
    {
        foreach($currentRow->all_childs as $childRow) {
            $childRow
                ->update([
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
                ]);
            if (sizeof($childRow->all_childs) > 0) {
                Self::updateChilds($childRow, $status);
            }
        }
    }

    public static function isValidParent($currentRow, $parent_id)
    {
        $isValid = true;
        foreach($currentRow->all_childs as $childRow) {
            if ($parent_id == $childRow->id) {
                $isValid = false;
                return $isValid;
                break;
            }
            else if (sizeof($childRow->all_childs) > 0) {
                Self::isValidParent($childRow, $parent_id);
            }
        }
        return $isValid;
    }

    public function destroy(TaskcardGroup $TaskcardGroup)
    {
        $currentRow = TaskcardGroup::where('id', $TaskcardGroup->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        TaskcardGroup::destroy($TaskcardGroup->id);
        return response()->json(['success' => 'Task Card Group Data has been Deleted']);
    }

    public function select2Parent(Request $request)
    {
        $search = $request->q;
        $query = TaskcardGroup::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $TaskcardGroups = $query->get();

        $response = [];
        foreach($TaskcardGroups as $TaskcardGroup){
            $response['results'][] = [
                "id"=>$TaskcardGroup->id,
                "text"=>$TaskcardGroup->name
            ];
        }

        return response()->json($response);
    }

    public function select2Child(Request $request)
    {
        $search = $request->q;

        $selectHaveParent = TaskcardGroup::orderby('name','asc')
                            ->select('parent_id')
                            ->where('parent_id', '<>', null)
                            ->where('status', 1);

        $query = TaskcardGroup::orderby('name','asc')
                    ->select('id','name')
                    ->whereNotIn('id', $selectHaveParent)
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $TaskcardGroups = $query->get();

        $response = [];
        foreach($TaskcardGroups as $TaskcardGroup){
            $response['results'][] = [
                "id"=>$TaskcardGroup->id,
                "text"=>$TaskcardGroup->name
            ];
        }

        return response()->json($response);
    }

}