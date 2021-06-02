<?php

namespace Modules\PPC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Modules\PPC\Entities\TaskcardDetailInstruction;
use Modules\PPC\Entities\TaskcardDetailItem;
use Modules\PPC\Entities\TaskcardGroup;
use Modules\PPC\Entities\WorkOrder;
use Modules\PPC\Entities\WorkOrderWorkPackageTaskcard;
use Modules\PPC\Entities\WOWPTaskcardDetailProgress;
use Modules\QualityAssurance\Entities\TaskReleaseLevel;
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

            if ($request->work_order_id && $request->work_order_id !== "null" ) {
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

                        foreach ($taskcard_group as $taskcard_group_row) {
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

                    if ( $row->details()->count() > 0 ) {
                        foreach ($row->details as $instruction_detail) {
                            $manhours_estimation += $instruction_detail->manhours_estimation ?? 0;
                        }
                    }

                    return number_format($manhours_estimation, 2, '.', '');
                })
                ->addColumn('actual_manhour', function ($row) {
                    $manhours_estimation = $row->actual_manhour;

                    return number_format($manhours_estimation, 2, '.', '');
                })
                ->addColumn('skills', function ($row) {
                    $skillsArray = collect(array());

                    $TaskcardDetailInstructions = $row->details;

                    if (!empty($TaskcardDetailInstructions)) {
                        foreach ($TaskcardDetailInstructions as $TaskcardDetailInstruction) {
                            $skills = collect(json_decode($TaskcardDetailInstruction->skills_json));
                            if (!$skills->isEmpty()) {
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
                ->addColumn('transaction_status_label', function ($row) {
                    return $row->transaction_status_label;
                })
                ->addColumn('action', function ($row) use ($request) {
                    $noAuthorize = true;

                    if ($request->user()->can('update', $row)) {
                        $noAuthorize = false;
                    }

                    if ($noAuthorize == false) {
                        return view('ppc::components.action-button', [
                            'status' => $row->currentUserProgress($row->id),
                            'executeable' => 'button',
                            'executeHref' => route('ppc.job-card.update', ['job_card' => $row->id, 'exec_all' => true]),
                            'executeText' => 'Execute All',
                            'pauseable' => 'button',
                            'pauseHref' => route('ppc.job-card.update', ['job_card' => $row->id]),
                            'resumeable' => 'button',
                            'resumeHref' => route('ppc.job-card.update', ['job_card' => $row->id]),
                            'closeable' => 'button',
                            'closeHref' => route('ppc.job-card.update', ['job_card' => $row->id]),
                            'releaseable' => 'button',
                            'releaseHref' => route('ppc.job-card.update', ['job_card' => $row->id]),
                        ]);
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

        $job_card_progresses = $job_card->progresses->groupBy(function ($progress) {
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

        return view('ppc::pages.job-card.edit', [
            'job_card' => $job_card,
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
        DB::beginTransaction();
        $flag = true;
        $job_card_transaction_status = config('ppc.job-card.transaction-status');
        $next_transaction_status = array_search($request->next_status, $job_card_transaction_status);
        /**
         * To do Validation list:
         *  [v]1. cek status jobcard, selain open, progress, pause tidak boleh update
         *  [v]2. cek apa yang akan dieksekusi apakah job card atau instruction
         *  [v]3. cek progress user apakah ada progress yang sedang berjalan
         *  [v]4. cek apa sudah ada progress / pernah di eksekusi
         *          jadi kalau sudah pernah di eksekusi exec_all tidak boleh diupdate progress detilnya
         *  [x]5. cek jumlah user yang telah progress pada jobcard/task tersebut apakah sudah melebih batas atau belum ( later )
         *  [x]6. cek apakah skill user dan skill pada jobcard/task telah sesusai ( later )
         *  [x]7. untuk proses close harus ada tambahan 
         *          menutup semua progress user lainnya pada object tersebut,
         *          dan mengupdate transaction status object tersebut
         */

        // 1. cek status jobcard, selain open, progress, pause tidak boleh update
        try {
            $is_authorized = $this->authorize('execute', $job_card);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()]);
        }

        // 3. cek progress user apakah ada progress yang sedang berjalan
        $last_progress = WOWPTaskcardDetailProgress::with('taskcard', 'instruction')->where('created_by',  $request->user()->id)->latest()->first();

        if ($last_progress->transaction_status == array_search('progress', $job_card_transaction_status)) {
            // if detail id is empty, user executing job-card, if not user executing task
            // 2. cek apa yang akan dieksekusi apakah job card atau instruction
            if (empty($request->detail_id)) {
                if ($last_progress->taskcard_id != $job_card->id) {
                    return response()->json(['error' => 'You have progress on another job card! ['.$last_progress->taskcard->code.']']);
                }
            } else {
                if ($last_progress->detail_id != $request->detail_id) {
                    return response()->json(['error' => 'You have progress on another job card! ['.$last_progress->taskcard->code.' -> '.$last_progress->instruction->code.']']);
                }
            }

        }
        // end 3. cek progress user apakah ada progress yang sedang berjalan

        if ($job_card->is_exec_all == null) {
            $result = $job_card->update([
                'is_exec_all' => $request->exec_all
            ]);

            if (!$result) {
                $flag = false;
            }
        }

        // update HEADER status row if still open
        if ($job_card->transaction_status == array_search('open', $job_card_transaction_status)) {
            if( $job_card->is_exec_all ) {
                $status = 'progress';
            }else{
                $status = 'partially progress';
            }

            // update job card status row 
            $result = $job_card->update([
                'transaction_status' => array_search($status, $job_card_transaction_status)
            ]);

            if (!$result) {
                $flag = false;
            }
        }

        // update DETAIL/INSTRUCTION status row if still open
        if (!empty($request->detail_id) && $job_card->details()->where('id', $request->detail_id)->first()->transaction_status ==  array_search('open', $job_card_transaction_status)) {
            $status = 'progress';

            $job_card->details()->where('id', $request->detail_id)->update([
                'transaction_status' => array_search($status, $job_card_transaction_status)
            ]);
        }

        // Progress close
        if ( strtolower($request->next_status) == 'close') {
            /** perlu refactor karena harus mengecek 
             * untuk job card yang close itu bukan hanya dari 1 task saja */
            $status = 'close';

            if (!$job_card->is_exec_all) {

                // update detail status row
                if (!empty($request->detail_id)) {
                    $job_card->details()->where('id', $request->detail_id)->update([
                        'transaction_status' => array_search($status, $job_card_transaction_status)
                    ]);
                }

                foreach ($job_card->details as $key => $row) {
                    $row->transaction_status =  config('ppc.job-card.transaction-status')[$row->transaction_status] ?? null;
                }
                
                // cek kalau semua detail apakah sudah close ?
                if($job_card->details->whereIn('transaction_status', ['open', 'pending', 'pause', 'progress'])->count() == 0) {
                    $result = $job_card->update([
                        'transaction_status' => array_search($status, $job_card_transaction_status)
                    ]);
    
                    if (!$result) {
                        $flag = false;
                    }
                }

            } else {
                // update job card status row 
                $result = $job_card->update([
                    'transaction_status' => array_search($status, $job_card_transaction_status)
                ]);

                if (!$result) {
                    $flag = false;
                }
            }
        }

        // Progress Release
        if( strtolower($request->next_status) == 'release') {

            if (!empty($request->detail_id)) {

                $detail = $job_card->details()->where('id', $request->detail_id)->first();
                $task_release_level = $detail->getNextTaskRelease();

                $result = $detail->update([
                    'transaction_status' => $task_release_level->uuid
                ]);

                if (!$result) {
                    $flag = false;
                }

                $next_transaction_status = $task_release_level->uuid;
            }
        }

        // Progress PAUSE/PENDING
        // Progress close
        if ( strtolower($request->next_status) == 'pause' || strtolower($request->next_status) == 'pending') {
            /** perlu refactor karena harus mengecek 
             * untuk job card yang close itu bukan hanya dari 1 task saja */
            $status = 'pending';

            if (!$job_card->is_exec_all) {

                // update detail status row
                if (!empty($request->detail_id)) {
                    $job_card->details()->where('id', $request->detail_id)->update([
                        'transaction_status' => array_search($status, $job_card_transaction_status)
                    ]);
                }

                foreach ($job_card->details as $key => $row) {
                    $row->transaction_status =  config('ppc.job-card.transaction-status')[$row->transaction_status] ?? null;
                }
                
                // cek kalau semua detail apakah sudah close ?
                if($job_card->details()->whereIn('transaction_status', ['pending', 'pause'])->count() == $job_card->details()->count()) {
                    $status = 'partially pending';

                    $result = $job_card->update([
                        'transaction_status' => array_search($status, $job_card_transaction_status)
                    ]);
    
                    if (!$result) {
                        $flag = false;
                    }
                }

            } else {
                // update job card status row 
                $result = $job_card->update([
                    'transaction_status' => array_search($status, $job_card_transaction_status)
                ]);

                if (!$result) {
                    $flag = false;
                }
            }
        }

        $new_progress = WOWPTaskcardDetailProgress::create([
            'uuid' => str::uuid(),
            'work_order_id' => $job_card->work_order_id,
            'work_package_id' => $job_card->work_package_id,
            'taskcard_id' => $job_card->id,
            'detail_id' => $request->detail_id ?? null,

            'transaction_status' => $next_transaction_status,
            'progress_notes' => $request->notes ?? null,

            'owned_by' => $request->user()->company_id,
            'status' => 1,
            'created_by' => $request->user()->id,
        ]);

        if (!get_class($new_progress)) {
            $flag = false;
        }

        if ($flag) {
            DB::commit();

            return response()->json(['success' => 'Job Cards has been updated', 'redirectUrl' => route('ppc.job-card.index')]);
        } else {
            DB::rollBack();

            return response()->json(['error' => 'Job Cards failed to update', 'redirectUrl' => route('ppc.job-card.index')]);
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

        if (empty($job_card)) {
            return redirect()->back()->with('error', 'Job Card Not Found');
        }

        try {
            $is_authorized = $this->authorize('execute', $job_card);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }

        /**
         * [x]tambahkan kondisi pengecekan status job card 
         *  apabila open atau progress masih bisa menuju halaman eksekusi
         *  apabila selain itu maka akan diarahkan menuju ke halaman show
         * 
         * [x]fitur dimasa depan akan ada pengecekan jumlah engineer/mechanic 
         *  yang bisa eksekusi jobcard
         */

        if ($job_card->transaction_status > 3) {
            $view = $this->show($request, $job_card);
        } else {
            $view = $this->edit($request, $job_card);
        }

        return $view;
    }

    public function print(Request $request)
    {
        return \PDF::loadView('ppc::pages.job-card.print')->stream();
    }
}
