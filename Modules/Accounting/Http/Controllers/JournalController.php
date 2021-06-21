<?php

namespace Modules\Accounting\Http\Controllers;

use Modules\Accounting\Entities\Journal;
use Modules\Accounting\Entities\JournalDetail;
use Modules\Accounting\Entities\JournalApproval;

use app\Helpers\Accounting\JournalProcess;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;

class JournalController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Journal::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Journal::with(['approvals',
                                'current_primary_currency:id,code,symbol,name',
                                'currency:id,code,symbol,name']);

            return Datatables::of($data)
            ->addColumn('reference', function($row) {
                if ($row->transaction_reference_text) {
                    return "<a target='_blank' href='" . $row->transaction_reference_url . "'>" . $row->transaction_reference_code . "</a>";
                } 
                else {
                    return "-";
                }
            })
            ->addColumn('type', function($row) {
                if ($row->transaction_reference_text) {
                    return $row->transaction_reference_text;
                }
                else {
                    return 'Manual Journal Entry';
                }
            })
            ->addColumn('total_amount', function($row) {
                return JournalProcess::totalDebit($row->id);
            })
            ->addColumn('creator_name', function($row) {
                if ($row->created_by != 0) {
                    return $row->creator->name;
                }
                else {
                    return 'System';
                }
            })
            ->addColumn('updater_name', function($row) {
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $noAuthorize = true;
                $updateable = null;
                $updateValue = null;
                $deleteable = null;
                $deleteId = null;
                $approvable = null;
                $approveId = null;

                if ($row->approvals()->count() > 0) {
                    return '<p class="text-muted font-italic">Already Approved</p>';
                }
                else {
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
                    if(Auth::user()->can('approval', Journal::class)) {
                        $approvable = true;
                        $approveId = $row->id;
                        $noAuthorize = false;
                    }
                    
                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId', 'approvable', 'approveId']));
                    }
                    else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                }
            })
            ->escapeColumns([])
            ->make(true);
        }
        return view('accounting::pages.journal.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => ['required', 'max:30'],
            'current_primary_currency_id' => ['required', 'max:30'],
            'currency_id' => ['required', 'max:30'],
            'exchange_rate' => ['required', 'max:30'],
            'description' => ['required'],
        ]);

        $transaction_date = Carbon::parse($request->transaction_date);
        $Journal = Journal::create([
            'uuid' =>  Str::uuid(),

            'transaction_date' => $transaction_date,
            'description' => $request->description,

            'current_primary_currency_id' => $request->current_primary_currency_id,
            'currency_id' => $request->currency_id,
            'exchange_rate' => $request->exchange_rate,

            'status' => 1,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
        ]);

        $code = 'JOURN-' . 
        $transaction_date->year . '-' .
        str_pad($Journal->id, 5, '0', STR_PAD_LEFT);

        $Journal->update([
            'code' => $code
        ]);
    
        return response()->json(['success' => 'Journal Data has been Saved',
                                    'id' => $Journal->id]);
    }

    public function show(Journal $Journal)
    {
        return view('accounting::pages.journal.show', compact('Journal'));
    }

    public function update(Request $request, Journal $Journal)
    {
        if ($Journal->approvals()->count() == 0) {
            $request->validate([
                'transaction_date' => ['required', 'max:30'],
                'current_primary_currency_id' => ['required', 'max:30'],
                'currency_id' => ['required', 'max:30'],
                'exchange_rate' => ['required', 'max:30'],
                'description' => ['required'],
            ]);

            $transaction_date = Carbon::parse($request->transaction_date);        
            $Journal->update([
                'transaction_date' => $transaction_date,
                'description' => $request->description,

                'current_primary_currency_id' => $request->current_primary_currency_id,
                'currency_id' => $request->currency_id,
                'exchange_rate' => $request->exchange_rate,

                'updated_by' => Auth::user()->id,
            ]);            
            return response()->json(['success' => 'Journal Data has been Updated',
                                        'id' => $Journal->id]);
        }
        else {
            return response()->json(['error' => "This Journal and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(Journal $Journal)
    {
        if ($Journal->approvals()->count() == 0) {
            $Journal->update([
                'deleted_by' => Auth::user()->id,
            ]);
            Journal::destroy($Journal->id);
            return response()->json(['success' => 'Journal Data has been Deleted']);
        }
        else {
            return response()->json(['error' => "This Journal and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function approve(Request $request, Journal $Journal)
    {
        return JournalProcess::approve($request, $Journal);
    }
}