<?php

namespace Modules\Examples\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Modules\Examples\Entities\Example;
use Yajra\DataTables\DataTables;

class ExampleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Example::class, 'example');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Example::latest()->get();
            return DataTables::of($data)
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return 'Edit';
                    } elseif ($row->status >= 2 && $row->status <= 7){
                        return ('Approve ' . $row->status);
                    } else{
                        return 'Posted';
                    }
                })
                ->addColumn('action', function($row){
                    $btnEdit = '';
//                    if (Gate::allows('approvable', [$row->status])) {
                    if(Auth::user()->can('approve', [Example::class, $row])) {
                        if ($row->status == 1){
                            $btnEdit .= '<button class="editBtn btn btn-sm btn-outline btn-primary pb-1 mb-2" value="'.$row->id.'">
                                        <i class="fa fa-edit"> Edit </i></button>';
                            $btnEdit .= '<br><button type="button" class="approveBtn btn btn-sm btn-success pb-1 mb-2" data-toggle="tooltip" title="Approve ' .$row->status. '" 
                            value="' . $row->id . '"><i class="fa fa-check-circle" id="approve1"></i></button>';
                        } elseif ($row->status >= 2 && $row->status <= 7){
                            $btnEdit .= '<button type="button" class="approveBtn btn btn-sm btn-success pb-1 mb-2" data-toggle="tooltip" title="Approve ' .$row->status. '" 
                            value="'.$row->id.'"><i class="fa fa-check-circle" id="approve1"></i></button>';
                        } else{
                            $btnEdit = '';
                        }
                    }
                    return $btnEdit;
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('examples::pages.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('examples::pages.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'max:255', 'alpha_dash', 'unique:examples'],
        ]);

        Example::create([
            'uuid' => Str::uuid(),
            'code' => $request->code,
            'name' => $request->name,
            'owned_by' => $request->user()->company_id,
            'created_by' => $request->user()->id,
            'status' => 1,
        ]);

        return response()->json(['success' => 'User data created successfully.']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Example $example)
    {
        return view('examples::pages.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Example $example)
    {
        return view('examples::pages.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Example $example)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'max:255', 'alpha_dash'],
            'status' => ['min:0', 'max:1'],
        ]);

        Example::where('id', $example->id)
            ->update([
                'name' => $request->name,
                'code' => $request->code,
                'status' => $request->status,
                'updated_by' => $request->user()->id,
            ]);

        return response()->json(['success' => 'User data updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Example $example)
    {
        //
    }

    public function approve(Example $example)
    {
        $this->authorize('approve', $example);

        Example::where('id', $example->id)
            ->update([
                'status' => ($example->status + 1),
                'updated_by' => Auth::user()->id,
            ]);

        return response()->json(['success' => 'Data approved successfully.']);
    }
}
