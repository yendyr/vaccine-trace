<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;

use app\Helpers\Accounting\JournalProcess;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class JournalDetailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(AircraftConfiguration::class, 'configuration_detail');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $journal_id = $request->journal_id;
        $Journal = Journal::where('id', $journal_id)->first();

        $approved = false;
        if ($Journal->approvals()->count() > 0) {
            $approved = true;
        }
        
        $data = JournalDetail::where('journal_id', $journal_id)
                                ->with(['coa']);
        
        return Datatables::of($data)
        // ->addColumn('debit', function($row){
        //     return $row->debit ?? '-';
        // })
        // ->addColumn('credit', function($row){
        //     return $row->credit ?? '-';
        // })
        ->addColumn('creator_name', function($row){
            return $row->creator->name ?? '-';
        })
        ->addColumn('updater_name', function($row){
            return $row->updater->name ?? '-';
        })
        ->addColumn('action', function($row) use ($approved) {
            if ($approved == false) {
                $noAuthorize = true;

                if(Auth::user()->can('update', Journal::class) && $row->created_by != 0) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', Journal::class) && $row->created_by != 0) {
                    $deleteable = true;
                    $deleteId = $row->id;
                    $noAuthorize = false;
                }

                if ($noAuthorize == false) {
                    return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
                }
                else {
                    return '<p class="text-muted font-italic">Not Authorized</p>';
                }
            }
            else {
                return '<p class="text-muted font-italic">Already Approved</p>';
            }
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function store(Request $request)
    {
        $journal_id = $request->journal_id;
        $Journal = Journal::where('id', $journal_id)->first();

        if ($Journal->approvals()->count() == 0) {
            $request->validate([
                'journal_id' => ['required'],
                'coa_id' => ['required'],
                'debit' => ['required_without_all:credit'],
                'credit' => ['required_without_all:debit'],
            ]);

            if (!JournalDetail::where('journal_id', '=', $journal_id)->where('coa_id', '=', $request->coa_id)->exists()) {
                JournalDetail::create([
                    'uuid' =>  Str::uuid(),
        
                    'journal_id' => $journal_id,
                    'coa_id' => $request->coa_id,
                    'debit' => $request->debit,
                    'credit' => $request->credit,
                    'description' => $request->description,
        
                    'owned_by' => $request->user()->company_id,
                    'status' => 1,
                    'created_by' => $request->user()->id,
                ]);
                return response()->json(['success' => 'Ledger Detail has been Added']);
            }
            else {
                return response()->json(['error' => "Selected COA Already Exists in this Journal, Choose Another COA"]);
            }
        }
        else {
            return response()->json(['error' => "This Journal and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function update(Request $request, JournalDetail $JournalDetail)
    {
        $journal_id = $JournalDetail->journal_id;
        $Journal = Journal::where('id', $journal_id)->first();

        if ($Journal->approvals()->count() == 0) {
            $request->validate([
                'journal_id' => ['required'],
                'coa_id' => ['required'],
                'debit' => ['required_without_all:credit'],
                'credit' => ['required_without_all:debit'],
            ]);

            if (!JournalDetail::where('journal_id', '=', $journal_id)->where('coa_id', '=', $request->coa_id)->where('id', '<>', $JournalDetail->id)->exists()) {
                $JournalDetail->update([
                    'coa_id' => $request->coa_id,
                    'debit' => $request->debit,
                    'credit' => $request->credit,
                    'description' => $request->description,

                    'updated_by' => $request->user()->id,
                ]);
                return response()->json(['success' => 'Ledger Detail has been Updated']);
            }
            else {
                return response()->json(['error' => "Selected COA Already Exists in this Journal, Choose Another COA"]);
            }
        }
        else {
            return response()->json(['error' => "This Journal and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(JournalDetail $JournalDetail)
    {
        $Journal = Journal::where('id', $JournalDetail->journal_id)->first();

        if ($Journal->approvals()->count() == 0) {
            $JournalDetail->update([
                'deleted_by' => Auth::user()->id,
            ]);
            JournalDetail::destroy($JournalDetail->id);
            return response()->json(['success' => 'Ledger Detail has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Journal and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }
}