<?php

namespace app\Helpers\Accounting;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\JournalApproval;
use Modules\Accounting\Entities\ChartOfAccount;
use Modules\GeneralSetting\Entities\Currency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JournalReport
{
    private static $total;

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

    public static function getBeginningDebitParent($coa_id, $start_date)
    {
        $coa = ChartOfAccount::with(['all_childs'])->where('id', $coa_id)->first();

        Self::$total = 0;
        $debit = Self::sumBeginningDebitParent($coa, $start_date);
        return $debit;
    }

    public static function sumBeginningDebitParent(ChartOfAccount $coa, $start_date)
    {
        foreach($coa->all_childs as $childRow) {
            $subTotal = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '<', $start_date);
                            })
                            ->where('coa_id', $childRow->id)
                            ->sum('debit');

            Self::$total = Self::$total + $subTotal;
            if (sizeof($childRow->all_childs) > 0) {
                Self::sumBeginningDebitParent($childRow, $start_date);
            }
        }
        return Self::$total;
    }
}
