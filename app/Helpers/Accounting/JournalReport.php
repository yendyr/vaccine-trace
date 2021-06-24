<?php

namespace app\Helpers\Accounting;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\JournalApproval;
use Modules\Accounting\Entities\ChartOfAccount;
use Modules\GeneralSetting\Entities\Currency;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

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

    public static function getBeginningBalance($coa_id, $start_date)
    {
        $debit = Self::getBeginningDebit($coa_id, $start_date);
        $credit = Self::getBeginningCredit($coa_id, $start_date);
        return ($debit - $credit);
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

    public static function getInPeriodBalance($coa_id, $start_date, $end_date)
    {
        $in_period_debit = Self::getInPeriodDebit($coa_id, $start_date, $end_date);
        $in_period_credit = Self::getInPeriodCredit($coa_id, $start_date, $end_date);

        return ($in_period_debit - $in_period_credit);
    }

    public static function getEndingBalance($coa_id, $start_date, $end_date)
    {
        return Self::getBeginningBalance($coa_id, $start_date) + Self::getInPeriodBalance($coa_id, $start_date, $end_date);
    }

    public static function getBeginningDebitParent($coa_id, $start_date)
    {
        $child_coas = ChartOfAccount::where('id', $coa_id)->first()->getAllChilds();

        $debit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '<', $start_date);
                            })
                            ->whereIn('coa_id', $child_coas)
                            ->sum('debit');
        return $debit;
    }

    public static function getBeginningCreditParent($coa_id, $start_date)
    {
        $child_coas = ChartOfAccount::where('id', $coa_id)->first()->getAllChilds();

        $credit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '<', $start_date);
                            })
                            ->whereIn('coa_id', $child_coas)
                            ->sum('credit');
        return $credit;
    }

    public static function getBeginningBalanceParent($coa_id, $start_date)
    {
        $debit = Self::getBeginningDebitParent($coa_id, $start_date);
        $credit = Self::getBeginningCreditParent($coa_id, $start_date);
        return ($debit - $credit);
    }

    public static function getInPeriodDebitParent($coa_id, $start_date, $end_date)
    {
        $child_coas = ChartOfAccount::where('id', $coa_id)->first()->getAllChilds();

        $debit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date, $end_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '>=', $start_date)
                                ->whereDate('transaction_date', '<=', $end_date);
                            })
                            ->whereIn('coa_id', $child_coas)
                            ->sum('debit');
        return $debit;
    }

    public static function getInPeriodCreditParent($coa_id, $start_date, $end_date)
    {
        $child_coas = ChartOfAccount::where('id', $coa_id)->first()->getAllChilds();

        $credit = JournalDetail::with(['journal'])
                            ->whereHas('journal', function ($journal) use ($start_date, $end_date) {
                                $journal->has('approvals')
                                ->whereDate('transaction_date', '>=', $start_date)
                                ->whereDate('transaction_date', '<=', $end_date);
                            })
                            ->whereIn('coa_id', $child_coas)
                            ->sum('credit');
        return $credit;
    }

    public static function getInPeriodBalanceParent($coa_id, $start_date, $end_date)
    {
        $in_period_debit = Self::getInPeriodDebitParent($coa_id, $start_date, $end_date);
        $in_period_credit = Self::getInPeriodCreditParent($coa_id, $start_date, $end_date);

        return ($in_period_debit - $in_period_credit);
    }

    public static function getEndingBalanceParent($coa_id, $start_date, $end_date)
    {
        return Self::getBeginningBalanceParent($coa_id, $start_date) + Self::getInPeriodBalanceParent($coa_id, $start_date, $end_date);
    }
}
