<?php

namespace app\Helpers\Accounting;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\JournalApproval;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JournalProcess
{
    public static function totalDebit($JournalId)
    {
        $total_debit = JournalDetail::where('journal_id', $JournalId)
                                ->sum('debit');
        if($total_debit) {
            return $total_debit;
        }
        else {
            return 0;
        }
    }

    public static function totalCredit($JournalId)
    {
        $total_credit = JournalDetail::where('journal_id', $JournalId)
                                ->sum('credit');
        if($total_credit) {
            return $total_credit;
        }
        else {
            return 0;
        }
    }

    public static function isBalance($JournalId)
    {
        $total_debit = JournalDetail::where('journal_id', $JournalId)
                                ->sum('debit');
        $total_credit = JournalDetail::where('journal_id', $JournalId)
                                ->sum('credit');
        if($total_debit == $total_credit) {
            return true;
        }
        else {
            return false;
        }
    }

    public static function approve(Request $request, Journal $Journal)
    {
        if ($Journal->journal_details()->count() > 0) {
            if (JournalProcess::isBalance($Journal->id)) {
                $request->validate([
                    'approval_notes' => ['required', 'max:30'],
                ]);
                
                JournalApproval::create([
                    'uuid' =>  Str::uuid(),
    
                    'journal_id' =>  $Journal->id,
                    'approval_notes' =>  $request->approval_notes,
            
                    'owned_by' => $request->user()->company_id,
                    'status' => 1,
                    'created_by' => $request->user()->id,
                ]);
                return response()->json(['success' => 'Journal Data has been Approved']);
            }
            else {
                return response()->json(['error' => "Debit and Credit not Balance Yet"]);
            }
        }
        else {
            return response()->json(['error' => "This Journal doesn't Have Any Detail Data"]);
        }
    }
}