<?php

namespace Modules\SupplyChain\Http\Controllers;

use Modules\SupplyChain\Entities\ItemStock;
use app\Helpers\SupplyChain\ItemStockChecker;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StockMonitoringController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ItemStock::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $warehouse_id = $request->warehouse_id;
        $with_use_button = $request->with_use_button;

        if ($request->ajax()) {
            return ItemStockChecker::usable_items($warehouse_id, $with_use_button);
        }

        if (!$warehouse_id) {
            return view('supplychain::pages.stock-monitoring.index');
        }
    }
}