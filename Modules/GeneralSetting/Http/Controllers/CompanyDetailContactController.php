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
        // if ($request->ajax()) {
        //     $data = CompanyDetailContact::all();
        //     return Datatables::of($data)
        //         ->addColumn('status', function($row){
        //             if ($row->status == 1){
        //                 return '<label class="label label-success">Active</label>';
        //             } else{
        //                 return '<label class="label label-danger">Inactive</label>';
        //             }
        //         })
        //         ->addColumn('creator_name', function($row){
        //             return $row->creator->name ?? '-';
        //         })
        //         ->addColumn('updater_name', function($row){
        //             return $row->updater->name ?? '-';
        //         })
        //         ->addColumn('action', function($row){
        //             $noAuthorize = true;
        //             if(Auth::user()->can('update', CompanyDetailContact::class)) {
        //                 $updateable = 'button';
        //                 $updateValue = $row->id;
        //                 $noAuthorize = false;
        //             }
        //             if(Auth::user()->can('delete', CompanyDetailContact::class)) {
        //                 $deleteable = true;
        //                 $deleteId = $row->id;
        //                 $noAuthorize = false;
        //             }

        //             if ($noAuthorize == false) {
        //                 return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId']));
        //             }
        //             else {
        //                 return '<p class="text-muted">Not Authorized</p>';
        //             }
                    
        //         })
        //         ->escapeColumns([])
        //         ->make(true);
        // }

        // return view('generalsetting::pages.company.index');
    }

    public function create()
    {
        // return view('generalsetting::pages.company.create');
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
        CompanyDetailContact::destroy($CompanyDetailContact->id);
        return response()->json(['success' => 'Data Deleted Successfully']);
    }

    public function select2Customer(Request $request)
    {
        // $search = $request->q;
        // $query = Company::orderby('name','asc')
        //                 ->select('id','name')
        //                 ->where('is_customer', 1)
        //                 ->where('status', 1);
        // if($search != ''){
        //     $query = $query->where('name', 'like', '%' .$search. '%');
        // }
        // $Companies = $query->get();

        // $response = [];
        // foreach($Companies as $Company){
        //     $response['results'][] = [
        //         "id"=>$Company->id,
        //         "text"=>$Company->name
        //     ];
        // }

        // return response()->json($response);
    }

    public function select2Supplier(Request $request)
    {
        // $search = $request->q;
        // $query = Company::orderby('name','asc')
        //                 ->select('id','name')
        //                 ->where('is_supplier', 1)
        //                 ->where('status', 1);
        // if($search != ''){
        //     $query = $query->where('name', 'like', '%' .$search. '%');
        // }
        // $Companies = $query->get();

        // $response = [];
        // foreach($Companies as $Company){
        //     $response['results'][] = [
        //         "id"=>$Company->id,
        //         "text"=>$Company->name
        //     ];
        // }

        // return response()->json($response);
    }

    public function select2Manufacturer(Request $request)
    {
    //     $search = $request->q;
    //     $query = Company::orderby('name','asc')
    //                     ->select('id','name')
    //                     ->where('is_manufacturer', 1)
    //                     ->where('status', 1);
    //     if($search != ''){
    //         $query = $query->where('name', 'like', '%' .$search. '%');
    //     }
    //     $Companies = $query->get();

    //     $response = [];
    //     foreach($Companies as $Company){
    //         $response['results'][] = [
    //             "id"=>$Company->id,
    //             "text"=>$Company->name
    //         ];
    //     }

    //     return response()->json($response);
    }
}