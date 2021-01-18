<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\CompanyDetailAddress;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyDetailAddressController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(CompanyDetailAddress::class);
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
        
        CompanyDetailAddress::create([
            'company_id' => $request->company_id,
            'uuid' => Str::uuid(),
            'label' => $request->label,
            'name' => $request->name,
            'street' => $request->street,
            'city' => $request->city,
            'province' => $request->province,
            'country_id' => $request->country_id,
            'post_code' => $request->post_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Address Data has been Added']);
    
    }

    public function show(CompanyDetailAddress $CompanyDetailAddress)
    {
        $CompanyDetailAddress = CompanyDetailAddress::where('id', $CompanyDetailAddress->id)
                                ->with('country:id,nice_name')
                                ->first();
        return response()->json($CompanyDetailAddress);
    }

    public function edit(CompanyDetailAddress $CompanyDetailAddress)
    {
        return view('generalsetting::pages.company-detail-address.edit', compact('CompanyDetailAddress'));
    }

    public function update(Request $request, CompanyDetailAddress $CompanyDetailAddress)
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
        
        $currentRow = CompanyDetailAddress::where('id', $request->id)->first();
        $currentRow
                ->update([
                    'label' => $request->label,
                    'name' => $request->name,
                    'street' => $request->street,
                    'city' => $request->city,
                    'province' => $request->province,
                    'country_id' => $request->country_id,
                    'post_code' => $request->post_code,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'owned_by' => $request->user()->company_id,
                    'status' => $status,
                    'updated_by' => $request->user()->id,
                ]);
        
        return response()->json(['success' => 'Address Data has been Updated']);
    
    }

    public function destroy(CompanyDetailAddress $CompanyDetailAddress)
    {
        $currentRow = CompanyDetailAddress::where('id', $CompanyDetailAddress->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        CompanyDetailAddress::destroy($CompanyDetailAddress->id);
        return response()->json(['success' => 'Address Data has been Deleted']);
    }

}