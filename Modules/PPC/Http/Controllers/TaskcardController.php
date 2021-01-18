<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class TaskcardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('ppc::pages.taskcard.index');
    }

    public function create()
    {
        return view('ppc::pages.taskcard.form');
    }

    public function store(Request $request)
    {
        
    }

    public function show(Taskcard $taskcard)
    {
        return view('ppc::show');
    }

    public function edit(Taskcard $taskcard)
    {
        return view('ppc::edit');
    }

    public function update(Request $request, Taskcard $taskcard)
    {
        
    }

    public function destroy(Taskcard $Taskcard)
    {
        $currentRow = Taskcard::where('id', $Taskcard->id)->first();
        $currentRow
                ->update([
                    'deleted_by' => Auth::user()->id,
                ]);

        Taskcard::destroy($Taskcard->id);
        return response()->json(['success' => 'Task Card Data has been Deleted']);
    }

}