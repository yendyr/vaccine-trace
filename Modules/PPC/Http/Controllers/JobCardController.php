<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailItem;
use Modules\PPC\Entities\TaskcardGroup;
use Modules\PPC\Entities\WorkOrder;
use Modules\PPC\Entities\WorkOrderWorkPackageTaskcard;
use Yajra\DataTables\Facades\DataTables;

class JobCardController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(WorkOrderWorkPackageTaskcard::class, 'job_card');
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function generate(Request $request)
    {
        $is_authorized = $this->authorize('view', WorkOrderWorkPackageTaskcard::class);

        if ($request->ajax()) {
            $data = WorkOrder::has('approvals');

            return Datatables::of($data)
                ->addColumn('number', function ($row) use ($request) {
                    $noAuthorize = true;
                    if ($request->user()->can('view', WorkOrder::class)) {
                        $showText = $row->code;
                        $showValue = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return  '<a href="' . route('ppc.work-order.show', ['work_order' => $showValue]) . '">' . $showText . '</a>';
                    } else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                })
                ->addColumn('status', function ($row) {
                    return ucfirst(config('ppc.work-order.status')[$row->status]) ?? '-';
                })
                ->addColumn('action', function ($row) use ($request) {
                    $noAuthorize = true;

                    if ($request->user()->can('generate', $row)) {
                        $generateable = 'button';
                        $generateValue = $row->id;
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['generateable', 'generateValue']));
                    } else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('ppc::pages.job-card.generate.index');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = WorkOrderWorkPackageTaskcard::where('type', array_search('job-card', config('ppc.job-card.type')))
                ->with([
                    'taskcard',
                    'taskcard.taskcard_type',
                    'taskcard.tags:id,code,name',
                    'work_package',
                ]);

            if ($request->work_order_id) {
                $data = $data->where('work_order_id', $request->work_order_id);
            }

            return Datatables::of($data)
                ->addColumn('mpd_number', function ($itemRow) {
                    return "<a href=" . route('ppc.work-order.work-package.taskcard.show', [
                        'taskcard' => $itemRow->id,
                        'work_order' => $itemRow->work_order_id,
                        'work_package' => $itemRow->work_package_id,
                    ]) . ">" . json_decode($itemRow->taskcard_json)->mpd_number . "</a>";
                })
                ->addColumn('jobcard_number', function ($itemRow) {
                    return "<a href=" . route('ppc.job-card.edit', [
                        'job_card' => $itemRow->id,
                    ]) . ">" . $itemRow->code . "</a>";
                })
                ->addColumn('group_structure', function ($row) {
                    $taskcard_group = json_decode($row->taskcard_group_json);

                    if (!empty($taskcard_group)) {

                        $group_structure = collect([]);

                        foreach($taskcard_group as $taskcard_group_row) {
                            $group_structure->prepend($taskcard_group_row->name);
                        }

                        return $group_structure->implode(' -> ');
                    } else {
                        return '-';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<label class="label label-success">Active</label>';
                    } else {
                        return '<label class="label label-danger">Inactive</label>';
                    }
                })
                ->addColumn('tag', function ($row) {
                    $tag_name = null;
                    $tag_details_json = json_decode($row->tag_details_json);

                    if (!empty($tag_details_json)) {
                        foreach ($row->job_card->tags as $tag) {
                            $tag_name .= $tag->name . ', ';
                        }

                        $tag_name = Str::beforeLast($tag_name, ',');
                    }

                    return $tag_name;
                })
                ->addColumn('instruction_count', function ($row) {
                    $instruction_details = $row->details()->count();

                    return $instruction_details;
                })
                ->addColumn('manhours_total', function ($row) {
                    $manhours_estimation = null;
                    $instruction_details_json =  json_decode($row->instruction_details_json);

                    if (!empty($instruction_details_json)) {
                        foreach ($instruction_details_json as $instruction_detail) {
                            $manhours_estimation += $instruction_detail->manhours_estimation ?? 0;
                        }
                    }

                    return number_format($manhours_estimation, 2, '.', '');
                })
                ->addColumn('skills', function ($row) {
                    $skillsArray = collect(array());
                    
                    $TaskcardDetailInstructions = $row->details;

                    if (!empty($TaskcardDetailInstructions)) {
                        foreach ($TaskcardDetailInstructions as $TaskcardDetailInstruction) {
                            $skills = collect(json_decode($TaskcardDetailInstruction->skills_json));
                            if( !$skills->isEmpty() ) {
                                $skillsArray = $skillsArray->concat($skills->pluck('name')->toArray());
                            }
                        }
                    }

                    return $skillsArray->unique()->implode(', ');
                })
                ->addColumn('threshold_interval', function ($row) {
                    $threshold_interval = '';
                    $taskcard_json = json_decode($row->taskcard_json);

                    if ($taskcard_json->threshold_flight_hour) {
                        $threshold_interval .= $taskcard_json->threshold_flight_hour . ' FH / ';
                    } else {
                        $threshold_interval .= '- FH / ';
                    }

                    if ($taskcard_json->threshold_flight_cycle) {
                        $threshold_interval .= $taskcard_json->threshold_flight_cycle . ' FC / ';
                    } else {
                        $threshold_interval .= '- FC / ';
                    }

                    if ($taskcard_json->threshold_daily) {
                        $threshold_interval .= $taskcard_json->threshold_daily . ' ' . $taskcard_json->threshold_daily_unit . '(s)';
                    } else {
                        $threshold_interval .= '- Day';
                    }

                    return $threshold_interval;
                })
                ->addColumn('repeat_interval', function ($row) {
                    $repeat_interval = '';
                    $taskcard_json = json_decode($row->taskcard_json);

                    if ($taskcard_json->repeat_flight_hour) {
                        $repeat_interval .= $taskcard_json->repeat_flight_hour . ' FH / ';
                    } else {
                        $repeat_interval .= '- FH / ';
                    }

                    if ($taskcard_json->repeat_flight_cycle) {
                        $repeat_interval .= $taskcard_json->repeat_flight_cycle . ' FC / ';
                    } else {
                        $repeat_interval .= '- FC / ';
                    }

                    if ($taskcard_json->repeat_daily) {
                        $repeat_interval .= $taskcard_json->repeat_daily . ' ' . $taskcard_json->repeat_daily_unit . '(s)';
                    } else {
                        $repeat_interval .= '- Day';
                    }

                    return $repeat_interval;
                })
                ->addColumn('creator_name', function ($row) {
                    return $row->creator->name ?? '-';
                })
                ->addColumn('updater_name', function ($row) {
                    return $row->updater->name ?? '-';
                })
                ->addColumn('action', function ($row) {
                    $noAuthorize = true;

                    if ($noAuthorize == false) {
                        return view('components.action-button', compact(['updateable', 'updateValue', 'deleteable', 'deleteId']));
                    } else {
                        return '<p class="text-muted font-italic">Not Authorized</p>';
                    }
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('ppc::pages.job-card.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('ppc::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, WorkOrderWorkPackageTaskcard $job_card)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param $job_card
     * @return Renderable
     */
    public function show(Request $request, WorkOrderWorkPackageTaskcard $job_card)
    {
        $job_card->taskcard_json = json_decode($job_card->taskcard_json);
        $job_card->taskcard_group_json = collect(json_decode($job_card->taskcard_group_json));
        $job_card->taskcard_type_json = json_decode($job_card->taskcard_type_json);
        $job_card->taskcard_workarea_json = json_decode($job_card->taskcard_workarea_json);
        $job_card->aircraft_types_json = json_decode($job_card->aircraft_types_json);
        $job_card->aircraft_type_details_json = json_decode($job_card->aircraft_type_details_json);
        $job_card->affected_items_json = json_decode($job_card->affected_items_json);
        $job_card->affected_item_details_json = json_decode($job_card->affected_item_details_json);
        $job_card->tags_json = json_decode($job_card->tags_json);
        $job_card->tag_details_json = json_decode($job_card->tag_details_json);
        $job_card->accesses_json = json_decode($job_card->accesses_json);
        $job_card->access_details_json = json_decode($job_card->access_details_json);
        $job_card->zones_json = json_decode($job_card->zones_json);
        $job_card->zone_details_json = json_decode($job_card->zone_details_json);
        $job_card->document_libraries_json = json_decode($job_card->document_libraries_json);
        $job_card->document_library_details_json = json_decode($job_card->document_library_details_json);
        $job_card->affected_manuals_json = json_decode($job_card->affected_manuals_json);
        $job_card->affected_manual_details_json = json_decode($job_card->affected_manual_details_json);
        $job_card->instruction_details_json = json_decode($job_card->instruction_details_json, true);
        $instruction_details_json = [];

        if (!empty($job_card->instruction_details_json)) {
            foreach ($job_card->instruction_details_json as $key => $instruction_array) {
                $instruction_details_json[] = new TaskcardDetailInstruction($instruction_array);
            }
        }

        $instruction_details_json = collect($instruction_details_json);
        $job_card->items_json = json_decode($job_card->items_json);
        $job_card->item_details_json = json_decode($job_card->item_details_json, true);

        $item_details_json = [];

        if (!empty($job_card->item_details_json)) {
            foreach ($job_card->item_details_json as $key => $item_detail_row) {
                $item_details_json[] = new TaskcardDetailItem($item_detail_row);
            }
        }
        
        $job_card_progresses = $job_card->progresses->groupBy(function( $progress ) {
            return $progress->created_at->format('Y');
        });

        return view('ppc::pages.job-card.show', [
            'job_card' => $job_card,
            'job_card_progresses' => $job_card_progresses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param $job_card
     * @return Renderable
     */
    public function edit(Request $request, WorkOrderWorkPackageTaskcard $job_card)
    {
        $job_card->taskcard_json = json_decode($job_card->taskcard_json);
        $job_card->taskcard_group_json = collect(json_decode($job_card->taskcard_group_json));
        $job_card->taskcard_type_json = json_decode($job_card->taskcard_type_json);
        $job_card->taskcard_workarea_json = json_decode($job_card->taskcard_workarea_json);
        $job_card->aircraft_types_json = json_decode($job_card->aircraft_types_json);
        $job_card->aircraft_type_details_json = json_decode($job_card->aircraft_type_details_json);
        $job_card->affected_items_json = json_decode($job_card->affected_items_json);
        $job_card->affected_item_details_json = json_decode($job_card->affected_item_details_json);
        $job_card->tags_json = json_decode($job_card->tags_json);
        $job_card->tag_details_json = json_decode($job_card->tag_details_json);
        $job_card->accesses_json = json_decode($job_card->accesses_json);
        $job_card->access_details_json = json_decode($job_card->access_details_json);
        $job_card->zones_json = json_decode($job_card->zones_json);
        $job_card->zone_details_json = json_decode($job_card->zone_details_json);
        $job_card->document_libraries_json = json_decode($job_card->document_libraries_json);
        $job_card->document_library_details_json = json_decode($job_card->document_library_details_json);
        $job_card->affected_manuals_json = json_decode($job_card->affected_manuals_json);
        $job_card->affected_manual_details_json = json_decode($job_card->affected_manual_details_json);
        $job_card->instruction_details_json = json_decode($job_card->instruction_details_json, true);
        $instruction_details_json = [];

        if (!empty($job_card->instruction_details_json)) {
            foreach ($job_card->instruction_details_json as $key => $instruction_array) {
                $instruction_details_json[] = new TaskcardDetailInstruction($instruction_array);
            }
        }

        $instruction_details_json = collect($instruction_details_json);
        $job_card->items_json = json_decode($job_card->items_json);
        $job_card->item_details_json = json_decode($job_card->item_details_json, true);

        $item_details_json = [];

        if (!empty($job_card->item_details_json)) {
            foreach ($job_card->item_details_json as $key => $item_detail_row) {
                $item_details_json[] = new TaskcardDetailItem($item_detail_row);
            }
        }
        
        $job_card_progresses = $job_card->progresses->groupBy(function( $progress ) {
            return $progress->created_at->format('Y');
        });

        return view('ppc::pages.job-card.edit', [
            'job_card' => $job_card,
            'job_card_progresses' => $job_card_progresses
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $job_card
     * @return Renderable
     */
    public function update(Request $request, WorkOrderWorkPackageTaskcard $job_card)
    {
        try {
            $is_authorized = $this->authorize('execute', $job_card);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param $job_card
     * @return Renderable
     */
    public function destroy(Request $request, WorkOrderWorkPackageTaskcard $job_card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param $job_card
     * @return Renderable
     */
    public function execute(Request $request)
    {        
        $job_card = WorkOrderWorkPackageTaskcard::where('uuid', $request->uuid)->first();

        if( empty($job_card) ){
            return redirect()->back()->with('error', 'Job Card Not Found');
        }

        try {
            $is_authorized = $this->authorize('execute', $job_card);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        $view = $this->edit($request, $job_card);

        return $view;
    }
}
