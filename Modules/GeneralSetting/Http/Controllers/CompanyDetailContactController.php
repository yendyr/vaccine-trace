<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\CompanyDetailContact;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyDetailContactController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(CompanyDetailContact::class);
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
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        
        CompanyDetailContact::create([
            'company_id' => $request->company_id,
            'uuid' => Str::uuid(),
            'label' => $request->label,
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'office_number' => $request->office_number,
            'fax_number' => $request->fax_number,
            'other_number' => $request->other_number,
            'website' => $request->website,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Contact Data has been Added']);
    
    }

    public function show(CompanyDetailContact $CompanyDetailContact)
    {
        $CompanyDetailContact = CompanyDetailContact::where('id', $CompanyDetailContact->id)
                                ->first();
        return response()->json($CompanyDetailContact);
    }

    public function edit(CompanyDetailContact $CompanyDetailContact)
    {
        return view('generalsetting::pages.company-contact.edit', compact('CompanyDetailContact'));
    }

    public function update(Request $request, CompanyDetailContact $CompanyDetailContact)
    {
        $request->validate([
            'name' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        
        $currentRow = CompanyDetailContact::where('id', $request->id)->first();
        $currentRow
                ->update([
                    'label' => $request->label,
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'office_number' => $request->office_number,
                    'fax_number' => $request->fax_number,
                    'other_number' => $request->other_number,
                    'website' => $request->website,
                    'status' => $status,
                    'updated_by' => $request->user()->id,
                ]);
        
        return response()->json(['success' => 'Contact Data has been Updated']);
    
    }

    public function destroy(CompanyDetailContact $CompanyDetailContact)
    {
        $currentRow = CompanyDetailContact::where('id', $CompanyDetailContact->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        CompanyDetailContact::destroy($CompanyDetailContact->id);
        return response()->json(['success' => 'Contact Data has been Deleted']);
    }

}