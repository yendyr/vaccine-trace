<?php

namespace Modules\PPC\Http\Controllers;

use Modules\SupplyChain\Entities\ItemStock;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class AircraftAgingController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ItemStock::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ItemStock::with(['item:id,code,name',
                                    'item_group',
                                    'warehouse'])
                                ->get();

            return Datatables::of($data)
                ->addColumn('parent', function($row){
                    if ($row->parent_id) {
                        return $row->item_group->item->code . ' | ' . 
                        $row->item_group->item->name . ' | ' .
                        $row->item_group->alias_name . ' | ';
                    } 
                    else {
                        return "<span class='text-muted font-italic'>Not Set</span>";
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('supplychain::pages.stock-monitoring.index');
    }
}