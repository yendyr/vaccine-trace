<?php

namespace Modules\Procurement\Http\Controllers;

use Modules\GeneralSetting\Entities\CompanyDetailAddress;
use Modules\Procurement\Entities\PurchaseRequisition;
use Modules\Procurement\Entities\PurchaseRequisitionApproval;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Procurement\Entities\PurchaseRequisitionDetail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class PurchaseRequisitionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(PurchaseRequisition::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseRequisition::with(['approvals']);

            return Datatables::of($data)
                ->addColumn('reference', function($row){
                    if ($row->transaction_reference_id) {
                        return $row->transaction_reference_id;
                    } 
                    else {
                        return "-";
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
                    $approvable = null;
                    $approveId = null;

                    if ($row->approvals()->count() > 0) {
                        if(Auth::user()->can('print', PurchaseRequisition::class)) {
                            $printable = true;
                            $printId = $row->id;
                            $printLink = "/procurement/purchase-requisition/$row->id/print";
                            $noAuthorize = false;
                        }

                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['printable', 'printId', 'printLink']));
                        }else{
                            return '<p class="text-muted font-italic">Already Approved</p>';
                        }
                    }
                    else {
                        if(Auth::user()->can('update', PurchaseRequisition::class)) {
                            $updateable = 'button';
                            $updateValue = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('delete', PurchaseRequisition::class)) {
                            $deleteable = true;
                            $deleteId = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('approval', PurchaseRequisition::class)) {
                            $approvable = true;
                            $approveId = $row->id;
                            $noAuthorize = false;
                        }
                        if(Auth::user()->can('print', PurchaseRequisition::class)) {
                            $printable = true;
                            $printId = $row->id;
                            $printLink = "/procurement/purchase-requisition/$row->id/print";
                            $noAuthorize = false;
                        }
                        
                        if ($noAuthorize == false) {
                            return view('components.action-button', compact(['updateable', 'updateValue','deleteable', 'deleteId', 'approvable', 'approveId', 'printable', 'printId', 'printLink']));
                        }
                        else {
                            return '<p class="text-muted font-italic">Not Authorized</p>';
                        }
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('procurement::pages.purchase-requisition.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_date' => ['required', 'max:30'],
            'description' => ['required'],
        ]);

        $transaction_date = Carbon::parse($request->transaction_date);

        DB::beginTransaction();
        $PurchaseRequisition = PurchaseRequisition::create([
            'uuid' =>  Str::uuid(),

            'transaction_date' => $transaction_date,
            'description' => $request->description,

            'status' => 1,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
        ]);

        $code = 'PCRQS-' . 
        $transaction_date->year . '-' .
        str_pad($PurchaseRequisition->id, 5, '0', STR_PAD_LEFT);

        $PurchaseRequisition->update([
            'code' => $code
        ]);
        DB::commit();
    
        return response()->json(['success' => 'Purchase Requisition Data has been Saved',
                                    'id' => $PurchaseRequisition->id]);
    }

    public function show(PurchaseRequisition $PurchaseRequisition)
    {
        return view('procurement::pages.purchase-requisition.show', compact('PurchaseRequisition'));
    }

    public function update(Request $request, PurchaseRequisition $PurchaseRequisition)
    {
        $currentRow = PurchaseRequisition::where('id', $PurchaseRequisition->id)->first();
        if ($currentRow->approvals()->count() == 0) {
            $request->validate([
                'transaction_date' => ['required', 'max:30'],
                'description' => ['required'],
            ]);

            $transaction_date = Carbon::parse($request->transaction_date);
        
            $currentRow->update([
                'transaction_date' => $transaction_date,
                'description' => $request->description,

                'updated_by' => Auth::user()->id,
            ]);
            
            return response()->json(['success' => 'Purchase Requisition Data has been Updated',
                                        'id' => $PurchaseRequisition->id]);
        }
        else {
            return response()->json(['error' => "This Purchase Requisition and It's Properties Already Approved, You Can't Modify this Data Anymore"]);
        }
    }

    public function destroy(PurchaseRequisition $PurchaseRequisition)
    {
        $currentRow = PurchaseRequisition::where('id', $PurchaseRequisition->id)->first();
        $currentRow
            ->update([
                'deleted_by' => Auth::user()->id,
            ]);

        PurchaseRequisition::destroy($PurchaseRequisition->id);
        return response()->json(['success' => 'Purchase Requisition Data has been Deleted']);
    }

    public function approve(Request $request, PurchaseRequisition $PurchaseRequisition)
    {
        if ($PurchaseRequisition->purchase_requisition_details()->count() > 0) {
            $request->validate([
                'approval_notes' => ['required', 'max:30'],
            ]);
    
            DB::beginTransaction();
            PurchaseRequisitionApproval::create([
                'uuid' =>  Str::uuid(),

                'purchase_requisition_id' =>  $PurchaseRequisition->id,
                'approval_notes' =>  $request->approval_notes,
        
                'owned_by' => $request->user()->company_id,
                'status' => 1,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            
            return response()->json(['success' => 'Purchase Requisition Data has been Approved']);
        }
        else {
            return response()->json(['error' => "This Purchase Requisition doesn't Have Any Detail Data"]);
        }
    }

    public function print(Request $request, PurchaseRequisition $PurchaseRequisition)
    {
        $company = Auth::user()->company;
        if ($company->logo == null)
            $company->logo =  './assets/default-company-logo.jpg';
        else{
            $company->logo = file_exists(public_path("/uploads/company/$company->id/logo/$company->logo")) ?
                "./uploads/company/$company->id/logo/$company->logo" : './assets/default-company-logo.jpg' ;
        }

        $companyAddress = CompanyDetailAddress::where('company_id', $company->id)->with('country')->first();

        $purchaseRequisition = PurchaseRequisition::whereId($PurchaseRequisition->id)->with(['purchase_requisition_details', 'approvals', 'creator'])->first();

        $details = PurchaseRequisitionDetail::where('purchase_requisition_id', $PurchaseRequisition->id)
            ->with(['item.unit',
                'item.category',
                'item_group:id,item_id,coding,parent_coding',
                'item_group.item'])
            ->get();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdfFile = $pdf->loadView('procurement::pages.purchase-requisition.print', [
            'company' => $company,
            'employee' => Auth::user()->employee,
            'companyAddress' => $companyAddress,
            'purchaseRequisition' => $purchaseRequisition,
            'qrcode' => base64_encode(QrCode::format('svg')->size(50)->errorCorrection('H')->generate($purchaseRequisition->uuid)),
            'details' => $details,
        ]);
        return $pdfFile->stream('PR.pdf');
    }
}