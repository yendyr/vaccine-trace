<?php

namespace Modules\GeneralSetting\Http\Controllers;

use Modules\GeneralSetting\Entities\Currency;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Currency::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Currency::with(['country']);

            return Datatables::of($data)
            ->addColumn('status', function($row){
                if ($row->status == 1){
                    return '<label class="label label-success">Active</label>';
                } else{
                    return '<label class="label label-danger">Inactive</label>';
                }
            })
            ->addColumn('is_primary', function($row){
                if ($row->is_primary == 1){
                    return '<label class="label label-primary">Yes</label>';
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

                if(Auth::user()->can('update', Currency::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', Currency::class) && $row->is_primary != 1) {
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
        return view('generalsetting::pages.currency.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required', 'max:30', 'unique:currencies,code'],
            'name' => ['required', 'max:30'],
            'symbol' => ['required', 'max:30'],
            'country_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->is_primary) {
            $is_primary = 1;
        } 
        else {
            $is_primary = 0;
        }

        DB::beginTransaction();
        $newCurrency = Currency::create([
            'uuid' =>  Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'symbol' => $request->symbol,
            'description' => $request->description,
            'country_id' => $request->country_id,
            'is_primary' => $is_primary,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        if ($is_primary == 1) {
            Currency::where('id', '<>', $newCurrency->id)->update(['is_primary' => 0]);
        }
        DB::commit();
        return response()->json(['success' => 'Currency Data has been Added']);
    
    }

    public function update(Request $request, Currency $Currency)
    {
        $request->validate([
            'code' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
            'symbol' => ['required', 'max:30'],
            'country_id' => ['required', 'max:30'],
        ]);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ($request->is_primary) {
            $is_primary = 1;
        } 
        else {
            $is_primary = 0;
        }

        DB::beginTransaction();
        if ($Currency->code == $request->code) {
            $Currency
                ->update([
                    'name' => $request->name,
                    'symbol' => $request->symbol,
                    'description' => $request->description,
                    'country_id' => $request->country_id,
                    'is_primary' => $is_primary,
                    
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $Currency
                ->update([
                    'code' => $request->code,
                    'symbol' => $request->symbol,
                    'description' => $request->description,
                    'country_id' => $request->country_id,
                    'is_primary' => $is_primary,
                    
                    'status' => $status,
                    'updated_by' => Auth::user()->id,
            ]);
        }
        if ($is_primary == 1) {
            Currency::where('id', '<>', $Currency->id)->update(['is_primary' => 0]);
        }
        DB::commit();
        return response()->json(['success' => 'Currency Data has been Updated']);
    }

    public function destroy(Currency $Currency)
    {
        $Currency->update([
            'deleted_by' => Auth::user()->id,
        ]);
        Currency::destroy($Currency->id);
        return response()->json(['success' => 'Currency Data has been Deleted']);
    }

    public function select2(Request $request)
    {
        $search = $request->q;
        $query = Currency::orderby('name','asc')
                ->where('status', 1);

        if($search != ''){
            $query = $query->where('name', 'like', '%' .$search. '%');
        }
        $Currencies = $query->get();

        $response = [];
        foreach($Currencies as $Currency){
            $response['results'][] = [
                "id" => $Currency->id,
                "text" => $Currency->code . ' | ' . 
                $Currency->symbol . ' | ' .
                $Currency->name
            ];
        }
        return response()->json($response);
    }

    public function select2Primary(Request $request)
    {
        // $search = $request->q;
        $Currencies = Currency::orderby('name','asc')
                ->where('status', 1)
                ->where('is_primary', 1)
                ->get();

        // if($search != ''){
        //     $query = $query->where('name', 'like', '%' .$search. '%');
        // }
        // $Currencies = $query->get();

        $response = [];
        foreach($Currencies as $Currency){
            $response['results'][] = [
                "id" => $Currency->id,
                "text" => $Currency->code . ' | ' . 
                $Currency->symbol . ' | ' .
                $Currency->name
            ];
        }
        return response()->json($response);
    }
}