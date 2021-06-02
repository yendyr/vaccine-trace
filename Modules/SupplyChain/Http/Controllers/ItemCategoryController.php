<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\ItemCategory;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ItemCategoryController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ItemCategory::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ItemCategory::with(['sales_coa:id,name',
                                        'inventory_coa:id,name',
                                        'cost_coa:id,name',
                                        'inventory_adjustment_coa:id,name',
                                        'work_in_progress_coa:id,name',]);

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
                if(Auth::user()->can('update', ItemCategory::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', ItemCategory::class)) {
                    $deleteable = true;
                    $deleteId = $row->id;
                    $noAuthorize = false;
                }

                if ($noAuthorize == false) {
                    return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                }
                else {
                    return '<p class="text-muted font-italic">Not Authorized</p>';
                }
                
            })
            ->escapeColumns([])
            ->make(true);
        }
        return view('supplychain::pages.item-category.index');
    }

    public function index_accounting(Request $request)
    {
        return view('accounting::pages.item-category.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:item_categories,code'],
            'name' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        ItemCategory::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
            'item_type' => $request->item_type,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Item Category has been Added']);
    
    }

    public function update(Request $request, ItemCategory $ItemCategory)
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

        $currentRow = ItemCategory::where('id', $ItemCategory->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'description' => $request->description,
                    'item_type' => $request->item_type,

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
                    'item_type' => $request->item_type,

                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Item Category Data has been Updated']);
    
    }

    public function update_accounting(Request $request, ItemCategory $ItemCategory)
    {
        $request->validate([
            'sales_coa_id' => ['required', 'max:30'],
            'inventory_coa_id' => ['required', 'max:30'],
            'cost_coa_id' => ['required', 'max:30'],
            'inventory_adjustment_coa_id' => ['required', 'max:30'],
            'work_in_progress_coa_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        ItemCategory::where('id', $ItemCategory->id)
        ->first()->update([
            'sales_coa_id' => $request->sales_coa_id,
            'inventory_coa_id' => $request->inventory_coa_id,
            'cost_coa_id' => $request->cost_coa_id,
            'inventory_adjustment_coa_id' => $request->inventory_adjustment_coa_id,
            'work_in_progress_coa_id' => $request->work_in_progress_coa,

            'status' => $status,
            'updated_by' => Auth::user()->id,
        ]);

        return response()->json(['success' => 'Item Category COA Data has been Updated']);
    
    }

    public function destroy(ItemCategory $ItemCategory)
    {
        $currentRow = ItemCategory::where('id', $ItemCategory->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        ItemCategory::destroy($ItemCategory->id);
        return response()->json(['success' => 'Item Category Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = ItemCategory::orderby('name','asc')
                    ->select('id','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $ItemCategories = $query->get();

        $response = [];
        foreach($ItemCategories as $ItemCategory){
            $response['results'][] = [
                "id"=>$ItemCategory->id,
                "text"=>$ItemCategory->name
            ];
        }
        return response()->json($response);
    }
}