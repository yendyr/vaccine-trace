<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\Company;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Company::all();
            
            return Datatables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<label class="label label-success">Active</label>';
                    } else{
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('is_customer', function($row){
                    if ($row->is_customer == 1){
                        return '<label class="label label-success">Yes</label>';
                    } else{
                        return '<label class="label label-danger">No</label>';
                    }
                })
                ->addColumn('is_supplier', function($row){
                    if ($row->is_supplier == 1){
                        return '<label class="label label-success">Yes</label>';
                    } else{
                        return '<label class="label label-danger">No</label>';
                    }
                })
                ->addColumn('is_manufacturer', function($row){
                    if ($row->is_manufacturer == 1){
                        return '<label class="label label-success">Yes</label>';
                    } else{
                        return '<label class="label label-danger">No</label>';
                    }
                })
                ->addColumn('creator_name', function($row){
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function($row){
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function($row){
                    $noAuthorize = true;
                    $updateable = null;
                    $updateValue = null;
                    $deleteable = null;
                    $deleteId = null;

                    if(Auth::user()->can('update', Company::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        $noAuthorize = false;
                    }
                    if(Auth::user()->can('delete', Company::class)) {
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
                    
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('generalsetting::pages.company.index');
    }

    public function create()
    {
        return view('generalsetting::pages.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'description' => ['max:100'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        if ($request->is_customer) {
            $is_customer = 1;
        } 
        else {
            $is_customer = 0;
        }
        if ($request->is_supplier) {
            $is_supplier = 1;
        } 
        else {
            $is_supplier = 0;
        }
        if ($request->is_manufacturer) {
            $is_manufacturer = 1;
        } 
        else {
            $is_manufacturer = 0;
        }

        Company::create([
            'uuid' => Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'gst_number' => $request->gst_number,
            'npwp_number' => $request->npwp_number,
            'description' => $request->description,
            'is_customer' => $is_customer,
            'is_supplier' => $is_supplier,
            'is_manufacturer' => $is_manufacturer,
            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Company Data has been Added']);    
    }

    public function show(Company $Company)
    {
        return view('generalsetting::pages.company.show', compact('Company'));
    }

    public function update(Request $request, Company $Company)
    {
        if ($request->updateAccounting != '1') {
            $request->validate([
                'code' => ['required', 'max:30'],
                'name' => ['required', 'max:30'],
                'description' => ['max:100'],
            ]);

            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }
            if ($request->is_customer) {
                $is_customer = 1;
            } 
            else {
                $is_customer = 0;
            }
            if ($request->is_supplier) {
                $is_supplier = 1;
            } 
            else {
                $is_supplier = 0;
            }
            if ($request->is_manufacturer) {
                $is_manufacturer = 1;
            } 
            else {
                $is_manufacturer = 0;
            }

            $currentRow = Company::where('id', $Company->id)->first();
            if ( $currentRow->code == $request->code) {
                $currentRow
                    ->update([
                        'name' => $request->name,
                        'gst_number' => $request->gst_number,
                        'npwp_number' => $request->npwp_number,
                        'description' => $request->description,
                        'is_customer' => $is_customer,
                        'is_supplier' => $is_supplier,
                        'is_manufacturer' => $is_manufacturer,
                        'status' => $status,
                        'updated_by' => $request->user()->id,
                    ]);
            }
            else {
                $currentRow
                    ->update([
                        'code' => $request->code,
                        'name' => $request->name,
                        'gst_number' => $request->gst_number,
                        'npwp_number' => $request->npwp_number,
                        'description' => $request->description,
                        'is_customer' => $is_customer,
                        'is_supplier' => $is_supplier,
                        'is_manufacturer' => $is_manufacturer,
                        'status' => $status,
                        'updated_by' => $request->user()->id,
                ]);
            }
        }
        else {
            $currentRow = Company::where('id', $Company->id)->first();
            $currentRow
                ->update([
                    'account_receivable_coa_id' => $request->account_receivable_coa_id,
                    'sales_discount_coa_id' => $request->sales_discount_coa_id,
                    'account_payable_coa_id' => $request->account_payable_coa_id,
                    'purchase_discount_coa_id' => $request->purchase_discount_coa_id,
                    'updated_by' => $request->user()->id,
                ]);
        }
        
        return response()->json(['success' => 'Company Data has been Updated']);
    }

    public function destroy(Company $Company)
    {
        $currentRow = Company::where('id', $Company->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Company::destroy($Company->id);
        return response()->json(['success' => 'Contact Data has been Deleted']);
    }

    public function select2Customer(Request $request)
    {
        $search = $request->q;
        $query = Company::orderby('name','asc')
                        ->select('id','name')
                        ->where('is_customer', 1)
                        ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Companies = $query->get();

        $response = [];
        foreach($Companies as $Company){
            $response['results'][] = [
                "id"=>$Company->id,
                "text"=>$Company->name
            ];
        }

        return response()->json($response);
    }

    public function select2Supplier(Request $request)
    {
        $search = $request->q;
        $query = Company::orderby('name','asc')
                        ->select('id','name')
                        ->where('is_supplier', 1)
                        ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Companies = $query->get();

        $response = [];
        foreach($Companies as $Company){
            $response['results'][] = [
                "id"=>$Company->id,
                "text"=>$Company->name
            ];
        }

        return response()->json($response);
    }

    public function select2Manufacturer(Request $request)
    {
        $search = $request->q;
        $query = Company::orderby('name','asc')
                        ->select('id','name')
                        ->where('is_manufacturer', 1)
                        ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Companies = $query->get();

        $response = [];
        foreach($Companies as $Company){
            $response['results'][] = [
                "id"=>$Company->id,
                "text"=>$Company->name
            ];
        }

        return response()->json($response);
    }

    public function select2Company(Request $request)
    {
        $search = $request->q;
        $query = Company::orderby('name','asc')
                        ->select('id','name')
                        ->where('status', 1);
        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Companies = $query->get();

        $response = [];
        foreach($Companies as $Company){
            $response['results'][] = [
                "id"=>$Company->id,
                "text"=>$Company->name
            ];
        }

        return response()->json($response);
    }

    public function logoUpload(Request $request, Company $Company)
    {
        if($request->ajax()) {
            $data = $request->file('file');
            $extension = $data->getClientOriginalExtension();
            $filename = 'company_logo_' . $Company->id . '.' . $extension;
            $path = public_path('uploads/company/' . $Company->id . '/logo/');
            // $path = public_path('uploads/user/img/');

            $usersImage = public_path('uploads/company/' . $Company->id . '/logo/' . $filename); // get previous image from folder

            if (File::exists($usersImage)) { // unlink or remove previous image from folder
                unlink($usersImage);
                $successText = 'Company Logo has been Updated';
            } else {
                $successText = 'Company Logo has been Updated';
            }

            Company::where('id', $Company->id)
                ->first()->update([
                    'logo' => $filename,
                    'updated_by' => $request->user()->id
                ]);

            $data->move($path, $filename);

            return response()->json(['success' => $successText]);
        }
    }

}