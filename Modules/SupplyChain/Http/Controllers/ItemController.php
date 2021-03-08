<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\Item;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Item::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Item::with(['sales_coa:id,name'])
                            ->with(['inventory_coa:id,name',
                                    'cost_coa:id,name',
                                    'inventory_adjustment_coa:id,name',
                                    'unit:id,name',
                                    'category:id,name',
                                    'manufacturer:id,name']);

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
                    if(Auth::user()->can('update', Item::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Item::class)) {
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

        return view('supplychain::pages.item.index');
    }

    public function index_accounting(Request $request)
    {
        return view('accounting::pages.item.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:items,code'],
            'name' => ['required', 'max:30'],
            'reorder_stock_level' => ['required', 'max:30'],
            'category_id' => ['required', 'max:30'],
            'primary_unit_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Item::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'model' => $request->model,
            'type' => $request->type,
            'description' => $request->description,
            'reorder_stock_level' => $request->reorder_stock_level,
            'category_id' => $request->category_id,
            'primary_unit_id' => $request->primary_unit_id,
            'manufacturer_id' => $request->manufacturer_id,
            'status' => $status,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Item has been Added']);
    
    }

    public function show(Item $Item)
    {
        return view('supplychain::pages.item.show');
    }

    public function edit(Item $Item)
    {
        return view('supplychain::pages.item.edit', compact('Item'));
    }

    public function update(Request $request, Item $Item)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'reorder_stock_level' => ['required', 'max:30'],
            'category_id' => ['required', 'max:30'],
            'primary_unit_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        $currentRow = Item::where('id', $Item->id)->first();
        if ( $currentRow->code == $request->code) {
            $currentRow
                ->update([
                    'name' => $request->name,
                    'model' => $request->model,
                    'type' => $request->type,
                    'description' => $request->description,
                    'reorder_stock_level' => $request->reorder_stock_level,
                    'category_id' => $request->category_id,
                    'primary_unit_id' => $request->primary_unit_id,
                    'manufacturer_id' => $request->manufacturer_id,
                    'status' => $status,
                    'owned_by' => $request->user()->company_id,
                    'updated_by' => $request->user()->id,
            ]);
        }
        else {
            $currentRow
                ->update([
                    'code' => $request->code,
                    'name' => $request->name,
                    'model' => $request->model,
                    'type' => $request->type,
                    'description' => $request->description,
                    'reorder_stock_level' => $request->reorder_stock_level,
                    'category_id' => $request->category_id,
                    'primary_unit_id' => $request->primary_unit_id,
                    'manufacturer_id' => $request->manufacturer_id,
                    'status' => $status,
                    'owned_by' => $request->user()->company_id,
                    'updated_by' => $request->user()->id,
            ]);
        }
        return response()->json(['success' => 'Item Data has been Updated']);
    
    }

    public function update_accounting(Request $request, Item $Item)
    {
        $request->validate([
            'sales_coa_id' => ['required', 'max:30'],
            'inventory_coa_id' => ['required', 'max:30'],
            'cost_coa_id' => ['required', 'max:30'],
            'inventory_adjustment_coa_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        Item::where('id', $Item->id)
            ->update([
                'sales_coa_id' => $request->sales_coa_id,
                'inventory_coa_id' => $request->inventory_coa_id,
                'cost_coa_id' => $request->cost_coa_id,
                'inventory_adjustment_coa_id' => $request->inventory_adjustment_coa_id,
                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);

        return response()->json(['success' => 'Item COA Data has been Updated']);
    
    }

    public function destroy(Item $Item)
    {
        $currentRow = Item::where('id', $Item->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Item::destroy($Item->id);
        return response()->json(['success' => 'Item Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;

        $query = Item::orderby('code','asc')
                    ->select('id','code','name')
                    ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%')
                            ->orWhere('code', 'like', '%' .$search. '%');
        }
        $Items = $query->get();

        $response = [];
        foreach($Items as $Item){
            $response['results'][] = [
                "id" => $Item->id,
                "text" => $Item->code . ' | ' . $Item->name
            ];
        }

        return response()->json($response);
    }

}