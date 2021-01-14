<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccountGroup;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ChartOfAccountGroupController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ChartOfAccountGroup::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ChartOfAccountGroup::with(['chart_of_account_class:id,name'])
                                        ->with(['chart_of_account_group:id,name']);
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
                    if(Auth::user()->can('update', ChartOfAccountGroup::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', ChartOfAccountGroup::class)) {
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

        $parentGroup = ChartOfAccountGroup::where('parent_id', null)
                                    ->where('status', 1)                
                                    ->get();

        return view('accounting::pages.chart-of-account-group.index', compact('parentGroup'));
    }

    public function create()
    {
        return view('accounting::pages.chart-of-account-group.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:chart_of_account_groups,code'],
            'name' => ['required', 'max:30'],
            'chart_of_account_class_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        ChartOfAccountGroup::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'chart_of_account_class_id' => $request->chart_of_account_class_id,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Chart of Account Group Data has been Added']);
    
    }

    public function show(ChartOfAccountGroup $ChartOfAccountGroup)
    {
        return view('accounting::pages.chart-of-account-group.show');
    }

    public function edit(ChartOfAccountGroup $ChartOfAccountGroup)
    {
        return view('accounting::pages.chart-of-account-group.edit', compact('ChartOfAccountGroup'));
    }

    public function update(Request $request, ChartOfAccountGroup $ChartOfAccountGroup)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'chart_of_account_class_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->parent_id == null || $request->parent_id == 'null' || $request->parent_id == '0') {
            $request->parent_id = null;
        }

        $currentRow = ChartOfAccountGroup::where('id', $ChartOfAccountGroup->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'parent_id' => $request->parent_id,
                    'chart_of_account_class_id' => $request->chart_of_account_class_id,
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
                    'chart_of_account_class_id' => $request->chart_of_account_class_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Chart of Account Group Data has been Updated']);
    
    }

    public function destroy(ChartOfAccountGroup $ChartOfAccountGroup)
    {
        ChartOfAccountGroup::destroy($ChartOfAccountGroup->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

    public function select2Parent(Request $request)
    {
        $search = $request->q;
        $query = ChartOfAccountGroup::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $ChartOfAccountGroups = $query->get();

        $response = [];
        foreach($ChartOfAccountGroups as $ChartOfAccountGroup){
            $response['results'][] = [
                "id"=>$ChartOfAccountGroup->id,
                "text"=>$ChartOfAccountGroup->name
            ];
        }

        return response()->json($response);
    }

    public function select2Child(Request $request)
    {
        $search = $request->q;

        $selectHaveParent = ChartOfAccountGroup::orderby('name','asc')
                            ->select('parent_id')
                            ->where('parent_id', '<>', null)
                            ->where('status', 1);

        $query = ChartOfAccountGroup::orderby('name','asc')
                    ->select('id','name')
                    ->whereNotIn('id', $selectHaveParent)
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $ChartOfAccountGroups = $query->get();

        $response = [];
        foreach($ChartOfAccountGroups as $ChartOfAccountGroup){
            $response['results'][] = [
                "id"=>$ChartOfAccountGroup->id,
                "text"=>$ChartOfAccountGroup->name
            ];
        }

        return response()->json($response);
    }

}