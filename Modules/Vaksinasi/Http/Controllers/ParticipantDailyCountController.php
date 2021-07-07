<?php

namespace Modules\Vaksinasi\Http\Controllers;

use Modules\Vaksinasi\Entities\ParticipantDailyCount;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class ParticipantDailyCountController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(ParticipantDailyCount::class, 'participant_daily');
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ParticipantDailyCount::with(['squad']);

            return Datatables::of($data)
            // ->addColumn('status', function($row) {
            //     if ($row->status == 1) {
            //         return '<label class="label label-success">Active</label>';
            //     } 
            //     else {
            //         return '<label class="label label-danger">Inactive</label>';
            //     }
            // })
            // ->addColumn('creator_name', function($row) {
            //     return $row->creator->name ?? '-';
            // })
            ->addColumn('updater_name', function($row) {
                return $row->updater->name ?? '-';
            })
            ->addColumn('action', function($row) {
                $noAuthorize = true;
                if(Auth::user()->can('update', ParticipantDailyCount::class)) {
                    $updateable = 'button';
                    $updateValue = $row->id;
                    $noAuthorize = false;
                }
                if(Auth::user()->can('delete', ParticipantDailyCount::class)) {
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
        return view('vaksinasi::pages.participant-daily.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required', 'max:30'],
            'squad_id' => ['required', 'max:30'],
            'category' => ['required', 'max:30'],
            'total' => ['required', 'max:30'],
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');

        $find_exist = ParticipantDailyCount::where('date', $date)
                                            ->where('squad_id', $request->squad_id)
                                            ->where('category', $request->category)
                                            ->first();

        if ($find_exist === null) {
            if ($request->status) {
                $status = 1;
            } 
            else {
                $status = 0;
            }
    
            ParticipantDailyCount::create([
                'uuid' =>  Str::uuid(),
                
                'date' => $date,
                'squad_id' => $request->squad_id,
                'category' => $request->category,
                'total' => $request->total,
    
                'owned_by' => $request->user()->company_id,
                'status' => $status,
                'created_by' => $request->user()->id,
            ]);
            return response()->json(['success' => 'Data Total Vaksinasi Harian Berhasil Ditambahkan']);  
        }
        else {
            return response()->json(['error' => 'Data Total Vaksinasi Harian untuk Tanggal/Satuan/Kategori Sudah Ada']);
        }
    }

    public function update(Request $request, ParticipantDailyCount $ParticipantDaily)
    {
        $request->validate([
            'date' => ['required', 'max:30'],
            'squad_id' => ['required', 'max:30'],
            'category' => ['required', 'max:30'],
            'total' => ['required', 'max:30'],
        ]);

        $date = Carbon::parse($request->date)->format('Y-m-d');

        $find_exist = ParticipantDailyCount::where('date', $date)
                                            ->where('squad_id', $request->squad_id)
                                            ->where('category', $request->category)
                                            ->first();

        if ($request->status) {
            $status = 1;
        } 
        else {
            $status = 0;
        }
        
        if ( $ParticipantDaily->date == $date && $ParticipantDaily->squad_id == $request->squad_id && $ParticipantDaily->category == $request->category) {
            $ParticipantDaily->update([
                'total' => $request->total,

                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'Data Total Vaksinasi Harian Berhasil Diubah']); 
        }
        else if ($find_exist === null){
            $ParticipantDaily->update([
                'date' => $date,
                'squad_id' => $request->squad_id,
                'category' => $request->category,
                'total' => $request->total,

                'status' => $status,
                'updated_by' => Auth::user()->id,
            ]);

            return response()->json(['success' => 'Data Total Vaksinasi Harian Berhasil Diubah']); 
        }
        else {
            return response()->json(['error' => 'Data Total Vaksinasi Harian untuk Tanggal/Satuan/Kategori Sudah Ada']);
        }
    }
    
    public function destroy(ParticipantDailyCount $ParticipantDaily)
    {
        $ParticipantDaily->update([
            'deleted_by' => Auth::user()->id,
        ]);

        ParticipantDailyCount::destroy($ParticipantDaily->id);
        return response()->json(['success' => 'Data Total Vaksinasi Harian Berhasil Dihapus']);
    }
}