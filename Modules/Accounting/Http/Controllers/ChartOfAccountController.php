<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccount;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ChartOfAccountController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ChartOfAccount::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ChartOfAccount::with(['chart_of_account_class:id,name,position',
                                        'chart_of_account:id,name']);

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
                    $updateable = null;
                    $updateValue = null;
                    $deleteable = null;
                    $deleteId = null;

                    if(Auth::user()->can('update', ChartOfAccount::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', ChartOfAccount::class)) {
                        $deleteable = true;
                        $deleteId = $row->id;
                        $noAuthorize = false;
                    }

                    if ($row->journal_details()->count() > 0) {
                        return '<p class="text-muted font-italic">Already Used in Transaction</p>';
                    }
                    else if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                    }
                    else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('accounting::pages.chart-of-account.index');
    }

    public function tree(Request $request)
    {
        $datas = ChartOfAccount::with(['chart_of_account'])
                                ->where('chart_of_accounts.status', 1)
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
            'code' => ['required', 'max:30', 'unique:chart_of_accounts,code'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        }
        else {
            $status = 0;
        }

        if ($request->parent_id) {
            $parent_chart_of_account_class_id = ChartOfAccount::where('id', $request->parent_id)
                    ->value('chart_of_account_class_id');

            $chart_of_account_class_id = $parent_chart_of_account_class_id;
        }
        else {
            $chart_of_account_class_id = $request->chart_of_account_class_id;
        }

        ChartOfAccount::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'chart_of_account_class_id' => $chart_of_account_class_id,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Chart of Account Data has been Added']);

    }

    public function update(Request $request, ChartOfAccount $ChartOfAccount)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        $currentRow = ChartOfAccount::where('id', $ChartOfAccount->id)
                                    ->with('all_childs')
                                    ->first();

        if ($request->status) {
            $status = 1;

            if ($currentRow->parent_id != null) {
                if ($currentRow->chart_of_account->status == 0) {
                    return response()->json(['error' => "This Item's Parent Status Still Deactivated, so You Can't Activate this Item"]);
                }
            }
        }
        else {
            $status = 0;
        }

        if ($request->parent_id == null || $request->parent_id == 'null' || $request->parent_id == '0') {
            $request->parent_id = null;
        }

        if ($request->parent_id) {
            $parent_chart_of_account_class_id = ChartOfAccount::where('id', $request->parent_id)
                    ->value('chart_of_account_class_id');

            $chart_of_account_class_id = $parent_chart_of_account_class_id;
        }
        else {
            $chart_of_account_class_id = $request->chart_of_account_class_id;
        }

        DB::beginTransaction();
        if ($currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'parent_id' => $request->parent_id,
                    'chart_of_account_class_id' => $chart_of_account_class_id,
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
                    'parent_id' => $request->parent_id,
                    'chart_of_account_class_id' => $chart_of_account_class_id,
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        if (sizeof($currentRow->all_childs) > 0) {
            Self::updateChilds($currentRow, $status);
        }
        DB::commit();
        return response()->json(['success' => 'Chart of Account Data has been Updated']);
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

    public function destroy(ChartOfAccount $ChartOfAccount)
    {
        $currentRow = ChartOfAccount::where('id', $ChartOfAccount->id)
                                    ->with('all_childs')
                                    ->first();
        if (sizeof($currentRow->all_childs) > 0) {
            return response()->json(['error' => "This COA Group has Child(s) Item, You Can't Directly Delete this COA Group"]);
        }
        else {
            $currentRow
                    ->update([
                        'deleted_by' => Auth::user()->id,
                    ]);
            ChartOfAccount::destroy($ChartOfAccount->id);
            return response()->json(['success' => 'Chart of Account Data has been Deleted']);
        }
    }

    public function select2Parent(Request $request)
    {
        $search = $request->q;
        $query = ChartOfAccount::with(['chart_of_account_class:id,name,position'])
                    ->orderby('code','asc')
                    // ->select('id', 'code', 'name')
                    ->doesnthave('journal_details')
                    ->where('status', 1);

        if($search != '') {
            $query = $query->where('name', 'like', '%' .$search. '%')
                            ->orWhere('code', 'like', '%' .$search. '%');
        }
        $ChartOfAccounts = $query->get();

        $response = [];
        foreach($ChartOfAccounts as $ChartOfAccount){
            $response['results'][] = [
                "id" => $ChartOfAccount->id,
                "text" => $ChartOfAccount->code . ' | ' . $ChartOfAccount->name . ' | Class: ' . $ChartOfAccount->chart_of_account_class->name
            ];
        }
        return response()->json($response);
    }

    public function select2Child(Request $request)
    {
        $search = $request->q;

        $selectHaveParent = ChartOfAccount::orderby('name','asc')
                            ->select('parent_id')
                            ->where('parent_id', '<>', null)
                            ->where('status', 1);

        $query = ChartOfAccount::orderby('name','asc')
                    ->select('id', 'code', 'name')
                    ->whereNotIn('id', $selectHaveParent)
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%')
                            ->orWhere('code', 'like', '%' .$search. '%');
        }
        $ChartOfAccounts = $query->get();

        $response = [];
        foreach($ChartOfAccounts as $ChartOfAccount){
            $response['results'][] = [
                "id"=>$ChartOfAccount->id,
                "text"=>$ChartOfAccount->code . ' | ' . $ChartOfAccount->name
            ];
        }
        return response()->json($response);
    }
}
