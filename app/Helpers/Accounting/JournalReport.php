<?php

namespace app\Helpers\Accounting;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\JournalApproval;
use Modules\GeneralSetting\Entities\Currency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JournalReport
{
    public static function getBeginningDebit($coa_id, $start_date)
    {
        $debit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '<', $start_date);
                            })
                            ->where('coa_id', $coa_id)
                            ->sum('debit');
        return $debit;
    }

    public static function getBeginningCredit($coa_id, $start_date)
    {
        $credit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '<', $start_date);
                            })
                            ->where('coa_id', $coa_id)
                            ->sum('credit');
        return $credit;
    }

    public static function getInPeriodDebit($coa_id, $start_date, $end_date)
    {
        $debit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date, $end_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '>=', $start_date)
                                ->whereDate('transaction_date', '<=', $end_date);
                            })
                            ->where('coa_id', $coa_id)
                            ->sum('debit');
        return $debit;
    }

    public static function getInPeriodCredit($coa_id, $start_date, $end_date)
    {
        $credit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date, $end_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '>=', $start_date)
                                ->whereDate('transaction_date', '<=', $end_date);
                            })
                            ->where('coa_id', $coa_id)
                            ->sum('credit');
        return $credit;
    }
}
