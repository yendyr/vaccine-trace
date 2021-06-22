<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccount;
use Modules\Accounting\Entities\Journal;

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
        $this->authorizeResource(Journal::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        if ($request->ajax()) {
            $data = ChartOfAccount::with(['parent', 'chart_of_account_class']);

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
                if (!$row->parent_id) {
                    return JournalReport::getBeginningDebitParent($row->id, $start_date);
                    // return '&nbsp;';
                }
                else {
                    return JournalReport::getBeginningDebit($row->id, $start_date);
                }
            })
            ->addColumn('beginning_credit', function($row) use ($start_date) {
                if (!$row->parent_id) {
                    return JournalReport::getBeginningCreditParent($row->id, $start_date);
                    // return '&nbsp;';
                }
                else {
                    return JournalReport::getBeginningCredit($row->id, $start_date);
                }
            })
            ->addColumn('in_period_debit', function($row) use ($start_date, $end_date) {
                if (!$row->parent_id) {
                    return JournalReport::getInPeriodDebitParent($row->id, $start_date, $end_date);
                    // return '&nbsp;';
                }
                else {
                    return JournalReport::getInPeriodDebit($row->id, $start_date, $end_date);
                }
            })
            ->addColumn('in_period_credit', function($row) use ($start_date, $end_date) {
                if (!$row->parent_id) {
                    return JournalReport::getInPeriodCreditParent($row->id, $start_date, $end_date);
                    // return '&nbsp;';
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
