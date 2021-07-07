<?php

namespace Modules\Vaksinasi\Http\Controllers;

use Modules\Vaksinasi\Entities\VaccinationParticipant;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class VaccinationParticipantController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(VaccinationParticipant::class);
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VaccinationParticipant::with(['squad']);

            return Datatables::of($data)
            ->addColumn('status', function($row) {
                if ($row->status == 1) {
                    return '<label class="label label-success">Active</label>';
                } 
                else {
                    return '<label class="label label-danger">Inactive</label>';
                }
            })
            ->addColumn('creator_name', function($row) {
                return $row->creator->name ?? '-';
            })
            ->addColumn('updater_name', function($row) {
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $noAuthorize = true;
                if(Auth::user()->can('update', VaccinationParticipant::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', VaccinationParticipant::class)) {
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
        return view('vaksinasi::pages.vaccination-participant.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required', 'max:30', 'unique:vaccination_participants,squad_id, id_type, id_number'],
            'squad_id' => ['required', 'max:30', 'unique:date, vaccination_participants, id_type, id_number'],
            'id_type' => ['required', 'max:30', 'unique:date, vaccination_participants, squad_id, id_number'],
            'id_number' => ['required', 'max:30', 'unique:date, vaccination_participants, squad_id, id_type'],

            'name' => ['required', 'max:30'],
        ]);

        $date = Carbon::parse($request->date);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        VaccinationParticipant::create([
            'uuid' =>  Str::uuid(),
            
            'date' => $date,
            'squad_id' => $request->squad_id,
            'id_type' => $request->id_type,
            'id_number' => $request->id_number,
            'category' => $request->category,
            'name' => $request->name,
            'address' => $request->address,
            'vaccine_used' => $request->vaccine_used,

            'owned_by' => $request->user()->company_id,
            'status' => $status,
            'created_by' => $request->user()->id,
        ]);
        return response()->json(['success' => 'Data Partisipan Vaksinasi Berhasil Ditambahkan']);    
    }

    public function update(Request $request, VaccinationParticipant $VaccinationParticipant)
    {
        $request->validate([
            'date' => ['required', 'max:30'],
            'squad_id' => ['required', 'max:30'],
            'id_type' => ['required', 'max:30'],
            'id_number' => ['required', 'max:30'],
            'name' => ['required', 'max:30'],
        ]);

        $date = Carbon::parse($request->date);

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }

        if ( $Squad->date == $date && $Squad->squad_id == $request->squad_id && $Squad->id_type == $request->id_type && $Squad->id_number == $request->id_number) {
            $Squad->update([
                'name' => $request->name,
                'address' => $request->address,
                'vaccine_used' => $request->vaccine_used,

                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        else {
            $request->validate([
                'date' => ['required', 'max:30', 'unique:vaccination_participants,squad_id, id_type, id_number'],
                'squad_id' => ['required', 'max:30', 'unique:date, vaccination_participants, id_type, id_number'],
                'id_type' => ['required', 'max:30', 'unique:date, vaccination_participants, squad_id, id_number'],
                'id_number' => ['required', 'max:30', 'unique:date, vaccination_participants, squad_id, id_type'],
    
                'name' => ['required', 'max:30'],
            ]);

            $Squad->update([
                'date' => $date,
                'squad_id' => $request->squad_id,
                'id_type' => $request->id_type,
                'id_number' => $request->id_number,
                'category' => $request->category,
                'name' => $request->name,
                'address' => $request->address,
                'vaccine_used' => $request->vaccine_used,

                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);
        }
        return response()->json(['success' => 'Data Partisipan Vaksinasi Berhasil Ditambahkan Diubah']);    
    }
    
    public function destroy(VaccinationParticipant $VaccinationParticipant)
    {
        $VaccinationParticipant->update([
            'deleted_by' => Auth::user()->id,
        ]);

        VaccinationParticipant::destroy($Squad->id);
        return response()->json(['success' => 'Data Partisipan Vaksinasi Berhasil Dihapus']);
    }
}