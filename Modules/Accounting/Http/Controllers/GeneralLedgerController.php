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

        $coas = $request->input('coas', []);

        if ($request->ajax()) {
            if (!empty($coas)) {
                $data = JournalDetail::with(['journal.currency',
                                                'coa'])
                                    ->whereHas('journal', function ($journal) use ($start_date, $end_date) {
                                        $journal->has('approvals')
                                        ->whereDate('transaction_date', '>=', $start_date)
                                        ->whereDate('transaction_date', '<=', $end_date);
                                    })
                                    ->whereIn('coa_id', $coas);
            }
            else {
                $data = JournalDetail::where('id', 'nothing');
            }

            return Datatables::of($data)
            ->addColumn('coa_title', function($row) use ($start_date, $end_date) {
                $beginningBalance = JournalReport::getBeginningBalance($row->coa->id, $start_date);
                $endingBalance = JournalReport::getEndingBalance($row->coa->id, $start_date, $end_date);

                return '<b>' . $row->coa->code . ' | ' . $row->coa->name . '</b></td><td colspan="6" class="text-right">Beginning Balance = <b>Rp. ' . number_format($beginningBalance, 0) . '</b>&emsp;&emsp;Ending Balance = <b>Rp. ' . number_format($endingBalance, 0);
            })
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
            ->escapeColumns([])
            ->make(true);
        }
        return view('accounting::pages.general-ledger.index');
    }
}
