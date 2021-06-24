<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccount;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\TrialBalance;

use app\Helpers\Accounting\JournalReport;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class TrialBalanceController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(TrialBalance::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->ajax()) {
            $data = ChartOfAccount::with(['parent', 'all_childs', 'chart_of_account_class']);

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
            ->addColumn('beginning_debit', function($row) use ($start_date) {
                if (sizeOf($row->all_childs) > 0) {
                    return JournalReport::getBeginningDebitParent($row->id, $start_date);
                }
                else {
                    return JournalReport::getBeginningDebit($row->id, $start_date);
                }
            })
            ->addColumn('beginning_credit', function($row) use ($start_date) {
                if (sizeOf($row->all_childs) > 0) {
                    return JournalReport::getBeginningCreditParent($row->id, $start_date);
                    // return '&nbsp;';
                }
                else {
                    return JournalReport::getBeginningCredit($row->id, $start_date);
                }
            })
            ->addColumn('in_period_debit', function($row) use ($start_date, $end_date) {
                if (sizeOf($row->all_childs) > 0) {
                    return JournalReport::getInPeriodDebitParent($row->id, $start_date, $end_date);
                }
                else {
                    return JournalReport::getInPeriodDebit($row->id, $start_date, $end_date);
                }
            })
            ->addColumn('in_period_credit', function($row) use ($start_date, $end_date) {
                if (sizeOf($row->all_childs) > 0) {
                    return JournalReport::getInPeriodCreditParent($row->id, $start_date, $end_date);
                }
                else {
                    return JournalReport::getInPeriodCredit($row->id, $start_date, $end_date);
                }
            })
            ->escapeColumns([])
            ->make(true);
        }
        return view('accounting::pages.trial-balance.index');
    }
}
