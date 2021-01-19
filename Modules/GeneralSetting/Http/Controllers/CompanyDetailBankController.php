<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\CompanyDetailBank;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyDetailBankController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(CompanyDetailBank::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        
    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'max:30'],
            'label' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        
        CompanyDetailBank::create([
            'company_id' => $request->company_id,
            'uuid' => Str::uuid(),
            'label' => $request->label,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'account_holder_name' => $request->account_holder_name,
            'account_number' => $request->account_number,
            'swift_code' => $request->swift_code,
            'description' => $request->description,
            'chart_of_account_id' => $request->chart_of_account_id,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Bank Data has been Added']);
    
    }

    public function show(CompanyDetailBank $CompanyDetailBank)
    {
        $CompanyDetailBank = CompanyDetailBank::where('id', $CompanyDetailBank->id)
                                ->with('chart_of_account:id,code,name')
                                ->first();
        return response()->json($CompanyDetailBank);
    }

    public function edit(CompanyDetailBank $CompanyDetailBank)
    {
        return view('generalsetting::pages.company-detail-bank.edit', compact('CompanyDetailBank'));
    }

    public function update(Request $request, CompanyDetailBank $CompanyDetailBank)
    {
        $request->validate([
            'label' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        
        $currentRow = CompanyDetailBank::where('id', $request->id)->first();
        $currentRow
                ->update([
                    'label' => $request->label,
                    'bank_name' => $request->bank_name,
                    'bank_branch' => $request->bank_branch,
                    'account_holder_name' => $request->account_holder_name,
                    'account_number' => $request->account_number,
                    'swift_code' => $request->swift_code,
                    'description' => $request->description,
                    'chart_of_account_id' => $request->chart_of_account_id,
                    'status' => $status,
                    'updated_by' => $request->user()->id,
                ]);
        
        return response()->json(['success' => 'Bank Data has been Updated']);
    
    }

    public function destroy(CompanyDetailBank $CompanyDetailBank)
    {
        $currentRow = CompanyDetailBank::where('id', $CompanyDetailBank->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        CompanyDetailBank::destroy($CompanyDetailBank->id);
        return response()->json(['success' => 'Bank Data has been Deleted']);
    }

}