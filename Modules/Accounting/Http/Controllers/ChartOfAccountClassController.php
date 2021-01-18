<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccountClass;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ChartOfAccountClassController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ChartOfAccountClass::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ChartOfAccountClass::all();
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
                    if(Auth::user()->can('update', ChartOfAccountClass::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', ChartOfAccountClass::class)) {
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

        return view('accounting::pages.chart-of-account-class.index');
    }

    public function create()
    {
        return view('accounting::pages.chart-of-account-class.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:chart_of_account_classes,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        ChartOfAccountClass::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Chart of Account Class Data has been Added']);
    
    }

    public function show(ChartOfAccountClass $ChartOfAccountClass)
    {
        return view('accounting::pages.chart-of-account-class.show');
    }

    public function edit(ChartOfAccountClass $ChartOfAccountClass)
    {
        return view('accounting::pages.chart-of-account-class.edit', compact('ChartOfAccountClass'));
    }

    public function update(Request $request, ChartOfAccountClass $ChartOfAccountClass)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = ChartOfAccountClass::where('id', $ChartOfAccountClass->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
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
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Chart of Account Group Class has been Updated']);
    
    }

    public function destroy(ChartOfAccountClass $ChartOfAccountClass)
    {
        $currentRow = ChartOfAccountClass::where('id', $ChartOfAccountClass->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        ChartOfAccountClass::destroy($ChartOfAccountClass->id);
        return response()->json(['success' => 'Chart of Account Group Class has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;
        $query = ChartOfAccountClass::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $ChartOfAccountClasses = $query->get();

        $response = [];
        foreach($ChartOfAccountClasses as $ChartOfAccountClass){
            $response['results'][] = [
                "id"=>$ChartOfAccountClass->id,
                "text"=>$ChartOfAccountClass->name
            ];
        }

        return response()->json($response);
    }
}