<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\ChartOfAccount;
use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\GeneralLedger;

use app\Helpers\Accounting\JournalReport;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class GeneralLedgerController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(GeneralLedger::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $coas = [];
        if ($request->coas) {
            foreach ($request->coas as $coa) {
                $coas = array_merge($coas, $coa);
            }
        }

        if ($request->ajax()) {
            $data = JournalDetail::with(['journal',
                                        'coa'])
                                ->whereHas('journal', function ($journal) use ($start_date, $end_date) {
                                    $journal->has('approvals')
                                    ->whereDate('transaction_date', '>=', $start_date)
                                    ->whereDate('transaction_date', '<=', $end_date);
                                });
                                // ->whereIn('coa_id', $coas)
                                // ->sum('credit');

            return Datatables::of($data)
            ->addColumn('type', function($row) {
                if ($row->journal->transaction_reference_text) {
                    return $row->journal->transaction_reference_text;
                }
                else {
                    return 'Manual Journal Entry';
                }
            })
            ->addColumn('reference', function($row) {
                if ($row->journal->transaction_reference_text) {
                    return "<a target='_blank' href='" . $row->journal->transaction_reference_url . "'>" . $row->journal->transaction_reference_code . "</a>";
                }
                else {
                    return "-";
                }
            })
            // ->addColumn('beginning_debit', function($row) use ($start_date) {
            //     if (sizeOf($row->all_childs) > 0) {
            //         return JournalReport::getBeginningDebitParent($row->id, $start_date);
            //     }
            //     else {
            //         return JournalReport::getBeginningDebit($row->id, $start_date);
            //     }
            // })
            // ->addColumn('beginning_credit', function($row) use ($start_date) {
            //     if (sizeOf($row->all_childs) > 0) {
            //         return JournalReport::getBeginningCreditParent($row->id, $start_date);
            //         // return '&nbsp;';
            //     }
            //     else {
            //         return JournalReport::getBeginningCredit($row->id, $start_date);
            //     }
            // })
            // ->addColumn('in_period_debit', function($row) use ($start_date, $end_date) {
            //     if (sizeOf($row->all_childs) > 0) {
            //         return JournalReport::getInPeriodDebitParent($row->id, $start_date, $end_date);
            //     }
            //     else {
            //         return JournalReport::getInPeriodDebit($row->id, $start_date, $end_date);
            //     }
            // })
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
        return view('accounting::pages.general-ledger.index');
    }
}
