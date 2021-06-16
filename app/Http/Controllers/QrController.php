<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// use Illuminate\Support\Str;
// use Yajra\DataTables\Facades\DataTables;

class QrController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        // $this->authorizeResource(ItemCategory::class);
        $this->middleware('auth');
    }

    public function single_qr(Request $request)
    {
        // if ($request->ajax()) {
            
        // }
        return QrCode::size(150)->generate($request->code);
    }
}