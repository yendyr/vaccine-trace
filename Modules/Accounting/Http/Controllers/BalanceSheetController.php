<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccount;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\BalanceSheet;

use app\Helpers\Accounting\JournalReport;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class BalanceSheetController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(BalanceSheet::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->ajax()) {
            $coas_income = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) {
                                    $class->where('name', 'Income');
                                })
                                ->pluck('id');

            $coas_expense = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) {
                                    $class->where('name', 'Expense');
                                })
                                ->pluck('id');

            $coas_liability = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) {
                                    $class->where('name', 'Liabilities');
                                })
                                ->pluck('id');

            $coas_equity = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) {
                                    $class->where('name', 'Equity');
                                })
                                ->pluck('id');

            $in_period_return = JournalReport::getInPeriodReturn($coas_income, $coas_expense, $start_date, $end_date);
            $in_period_liabilities = JournalReport::getEndingBalanceClass($coas_liability, $start_date, $end_date);
            $in_period_equity = JournalReport::getEndingBalanceClass($coas_equity, $start_date, $end_date);
            $total_liabilites_equity = $in_period_liabilities + $in_period_equity;

            $data = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) {
                                    $class->where('name', 'Assets')
                                        ->orWhere('name', 'Liabilities')
                                        ->orWhere('name', 'Equity');
                                });

            return Datatables::of($data)
            ->with('in_period_return', $in_period_return)
            ->with('total_liabilites_equity', $total_liabilites_equity)
            ->addColumn('coa_class', function($row) use ($start_date, $end_date) {
                $coas_class = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class'])
                                ->whereHas('chart_of_account_class', function ($class) use ($row) {
                                    $class->where('id', $row->chart_of_account_class_id);
                                })
                                ->pluck('id');

                return $row->chart_of_account_class->name . ', Total: Rp. ' . number_format(JournalReport::getEndingBalanceClass($coas_class, $start_date, $end_date),0);
            })
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
            // ->addColumn('all_time_balance', function($row) {
            //     if (sizeOf($row->all_childs) > 0) {
            //         return JournalReport::getInPeriodBalanceParent($row->id, '1970-01-01', '2999-12-31');
            //     }
            //     else {
            //         return JournalReport::getInPeriodBalance($row->id, '1970-01-01', '2999-12-31');
            //     }
            // })
            ->escapeColumns([])
            ->make(true);
        }
        return view('accounting::pages.balance-sheet.index');
    }
}
