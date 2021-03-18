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
        if ($request->ajax()) {
            return ItemStockChecker::all_status()
                ->escapeColumns([])
                ->make(true);
        }
        return view('supplychain::pages.stock-monitoring.index');
    }
}