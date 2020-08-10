<?php

namespace Modules\HumanResources\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Modules\HumanResources\Entities\Holiday;
use Modules\HumanResources\Rules\SundayHolidayRule;
use Yajra\DataTables\Facades\DataTables;
use yii\validators\Validator;

class HolidayController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Holiday::class, 'holiday');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Holiday::latest()->get();
            return DataTables::of($data)
                ->addColumn('holidaycode', function($row){
                    $holidays = [
                        "Other", "New Year's Day", "Chinese New Year's Day", "Isra' Mi'raj of the Prophet Muhammad", "Hindu New Year (Nyepi)",
                        "Good Friday", "International Labour Day", "Waisak Day", "Ascension Day of Jesus Christ", "Idul Fitri", "Pancasila Day",
                        "Idul Adha", "Indonesian Independence Day", "Islamic New Year", "Prophet Muhammad's Birthday", "Christmas Day"
                    ];
                    $indexCode = sprintf("%01d", $row->holidaycode);
                    $holidaycode['name'] = ($row->holidaycode . ' - ' . $holidays[$indexCode]);
                    $holidaycode['value'] = $row->holidaycode;
                    return $holidaycode;
                })
                ->addColumn('holidaydate', function($row){
                    $date = date_create($row->holidaydate);
                    $date = date_format($date,"d M");
                    $holidaydate['name'] = $date;
                    $holidaydate['value'] = $row->holidaydate;
                    return $holidaydate;
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1){
                        return '<p class="text-success">Active</p>';
                    } else{
                        return '<p class="text-danger">Inactive</p>';
                    }
                })
                ->addColumn('action', function($row){
                    if(Auth::user()->can('update', Holiday::class)) {
                        $updateable = 'button';
                        $updateValue = $row->id;
                        return view('components.action-button', compact(['updateable', 'updateValue']));
                    }else{
                        return '<p class="text-muted">no action authorized</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('humanresources::pages.holiday.index');
    }

    public function select2Code(Request $request)
    {
        $search = $request->q;
        $holidays = [
            "Other", "New Year's Day", "Chinese New Year's Day", "Isra' Mi'raj of the Prophet Muhammad", "Hindu New Year (Nyepi)",
            "Good Friday", "International Labour Day", "Waisak Day", "Ascension Day of Jesus Christ", "Idul Fitri", "Pancasila Day",
            "Idul Adha", "Indonesian Independence Day", "Islamic New Year", "Prophet Muhammad's Birthday", "Christmas Day"
        ];

        if($search != ''){
            foreach ($holidays as $i => $value) {
                if (stripos($value, $search) !== false) {
                    $results[$i] = $value;
                }
            }
        } else{
            $results = $holidays;
        }

        $response = [];
        foreach($results as $i => $result){
            $response['results'][] = [
                "id"=>sprintf("%02d", $i),
                "text"=>(sprintf("%02d", $i) .' - '. $result)
            ];
        };

        return response()->json($response);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('humanresources::pages.holiday.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->ajax()){
            //validation for min & max year
            $currentYear = intval(date("Y"));
            $maxYear = $currentYear + 100;

            //validation for matching year
            $yearOfDate = explode('-', $request->holidaydate);
            $yearOfDate = intval($yearOfDate[0]);

            $request->validate([
                'holidayyear' => ['required', 'numeric', 'max:' . $maxYear, 'min:' .$currentYear,
                    'in:' . intval($yearOfDate)
                ],
                'holidaydate' => ['required', 'date'],
                'holidaycode' => ['required', 'string', 'size:2',
                    Rule::unique('holidays')->where(function ($query) use($request) {
                        return $query->where('holidaycode', $request->holidaycode)
                            ->where('holidaydate', $request->holidaydate)
                            ->where('holidayyear', $request->holidayyear);
                    })],
                'remark' => ['nullable', 'string'],
                'status' => ['required', 'min:0', 'max:1'],
            ]);

            $dml = Holiday::create([
                'uuid' => Str::uuid(),
                'holidayyear' => $request->holidayyear,
                'holidaydate' => $request->holidaydate,
                'holidaycode' => $request->holidaycode,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'created_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a new Holiday added successfully.']);
            }
            return response()->json(['error' => 'Error when creating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    public function generateSundays(Request $request){
        if ($request->ajax()){
            //validation for min & max year
            $currentYear = intval(date("Y"));
            $maxYear = $currentYear + 100;

            $request->validate([
                'sundayyear' => ['required', 'numeric', 'max:' . $maxYear, 'min:' .$currentYear, new SundayHolidayRule],
            ]);

            //get date every sunday
            $sundayyear = $request->sundayyear;
            $fullDate = $request->sundayyear . "-01-01";
            //check if not sunday, get closest sunday
            $date = date_create($fullDate);
            $day = date_format($date,"D");
            while ($day != 'Sun'){
                $nextDay = strtotime($fullDate) + 86400;
                $fullDate = date("Y-m-d", $nextDay);
                $date = date_create($fullDate);
                $day = date_format($date,"D");
            }

            while ($sundayyear == $request->sundayyear){
                $dml = Holiday::create([
                    'uuid' => Str::uuid(),
                    'holidayyear' => $sundayyear,
                    'holidaydate' => $fullDate,
                    'holidaycode' => '00',
                    'remark' => "Sunday Holiday",
                    'status' => 1,
                    'owned_by' => $request->user()->company_id,
                    'created_by' => $request->user()->id,
                ]);
                $nextSunday = strtotime($fullDate) + 604800;
                $fullDate = date("Y-m-d",$nextSunday);
                $sundayyear = explode('-', $fullDate)[0];

                if (!$dml){
                    return response()->json(['error' => 'Error when creating data!']);
                }
            }
            return response()->json(['success' => 'new Sunday Holidays added successfully.']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Holiday $holiday)
    {
        return view('humanresources::pages.holiday.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Holiday $holiday)
    {
        return view('humanresources::pages.holiday.edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        if ($request->ajax()){
            //get existed data based on id
            $holidaydata = Holiday::find($holiday->id);
            $holidayyear = $holidaydata->holidayyear;
            $holidaydate = $holidaydata->holidaydate;
            $holidaycode = $holidaydata->holidaycode;

            if ( ($request->holidayyear == $holidayyear) &&
                ($request->holidaydate == $holidaydate) &&
                ($request->holidaycode == $holidaycode)){
                $request->validate([
                    'remark' => ['nullable', 'string'],
                    'status' => ['required', 'min:0', 'max:1'],
                ]);
            } else {
                //validation for min & max year
                $currentYear = intval(date("Y"));
                $maxYear = $currentYear + 100;

                //validation for matching year
                $yearOfDate = explode('-', $request->holidaydate);
                $yearOfDate = intval($yearOfDate[0]);

                $request->validate([
                    'holidayyear' => ['required', 'numeric', 'max:' . $maxYear, 'min:' .$currentYear,
                        'in:' . intval($yearOfDate)
                    ],
                    'holidaydate' => ['required', 'date'],
                    'holidaycode' => ['required', 'string', 'size:2',
                        Rule::unique('holidays')->where(function ($query) use($request) {
                            return $query->where('holidaycode', $request->holidaycode)
                                ->where('holidaydate', $request->holidaydate)
                                ->where('holidayyear', $request->holidayyear);
                        })],
                    'remark' => ['nullable', 'string'],
                    'status' => ['required', 'min:0', 'max:1'],
                ]);
            }

            $dml = Holiday::where('id', $holiday->id)
                ->update([
                'holidayyear' => $request->holidayyear,
                'holidaydate' => $request->holidaydate,
                'holidaycode' => $request->holidaycode,
                'remark' => $request->remark,
                'status' => $request->status,
                'owned_by' => $request->user()->company_id,
                'updated_by' => $request->user()->id,
            ]);
            if ($dml){
                return response()->json(['success' => 'a Holiday data updated successfully.']);
            }
            return response()->json(['error' => 'Error when updating data!']);
        }
        return response()->json(['error' => 'Error not a valid request']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy(Holiday $holiday)
    {
        //
    }
}
