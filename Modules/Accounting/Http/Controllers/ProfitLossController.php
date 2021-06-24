<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccount;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\ProfitLoss;

use app\Helpers\Accounting\JournalReport;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProfitLossController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ProfitLoss::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->ajax()) {
            $data = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) {
                                    $class->where('name', 'Income')
                                        ->orWhere('name', 'Expense');
                                });

            return Datatables::of($data)
            ->addColumn('coa_name', function($row) {
                if ($row->parent_id) {
                    if ($row->parent->parent_id) {
                        return '&emsp;&emsp;&emsp;&emsp;' . $row->name;
                    }
                    return '&emsp;&emsp;' . $row->name;
                }
                else {
                    return $row->name;
                }
            })
            ->addColumn('in_period_balance', function($row) use ($start_date, $end_date) {
                if (sizeOf($row->all_childs) > 0) {
                    return JournalReport::getInPeriodBalanceParent($row->id, $start_date, $end_date);
                }
                else {
                    return JournalReport::getInPeriodBalance($row->id, $start_date, $end_date);
                }
            })
            // ->addColumn('in_period_credit', function($row) use ($start_date, $end_date) {
            //     if (sizeOf($row->all_childs) > 0) {
            //         return JournalReport::getInPeriodCreditParent($row->id, $start_date, $end_date);
            //     }
            //     else {
            //         return JournalReport::getInPeriodCredit($row->id, $start_date, $end_date);
            //     }
            // })
            ->escapeColumns([])
            ->make(true);
        }
        return view('accounting::pages.profit-loss.index');
    }
}
