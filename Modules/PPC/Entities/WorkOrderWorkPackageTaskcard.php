<?php

namespace Modules\PPC\Entities;

use App\MainModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class WorkOrderWorkPackageTaskcard extends MainModel
{
    use softDeletes;
    use Notifiable;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid',
        'work_order_id',
        'work_package_id',
        'taskcard_id',
        'code',
        'transaction_status',
        'type',
        'description',
        'is_exec_all',
        'is_subcon',

        'taskcard_json',
        'taskcard_group_json',
        'taskcard_type_json',
        'taskcard_workarea_json',
        'aircraft_types_json',
        'aircraft_type_details_json',
        'affected_items_json',
        'affected_item_details_json',
        'tags_json',
        'tag_details_json',
        'accesses_json',
        'access_details_json',
        'zones_json',
        'zone_details_json',
        'document_libraries_json',
        'document_library_details_json',
        'affected_manuals_json',
        'affected_manual_details_json',
        'task_tree_json',
        
        'status',
        'created_by',
        'updated_by',
        'owned_by',
        'deleted_by',
    ];

    public function creator()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(\Modules\Gate\Entities\User::class, 'updated_by');
    }

    public function work_order()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrder::class, 'work_order_id');
    }
    
    public function work_package()
    {
        return $this->belongsTo(\Modules\PPC\Entities\WorkOrderWorkPackage::class, 'work_package_id');
    }

    public function taskcard()
    {
        return $this->belongsTo(\Modules\PPC\Entities\Taskcard::class, 'taskcard_id');
    }

    public function items()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailItem::class, 'taskcard_id');
    }

    public function details()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetail::class, 'taskcard_id');
            // ->where('work_order_id', $this->work_order_id)
            // ->where('work_package_id', $this->work_package_id);
    }

    public function progresses()
    {
        return $this->hasMany(\Modules\PPC\Entities\WOWPTaskcardDetailProgress::class, 'taskcard_id')
            ->where('work_order_id', $this->work_order_id)
            ->where('work_package_id', $this->work_package_id);
    }

    public function currentUserProgress($taskcard_id)
    {
        $latest_progress = $this->progresses()
        ->where('taskcard_id', $taskcard_id)
        ->where('created_by', Auth::user()->id)->latest()->first();
        
        return $latest_progress->transaction_status ?? 1;
    }

    public function getTransactionStatusLabelAttribute(){
        $transaction_status = null;

        if($this->transaction_status) {
            $transaction_status = config('ppc.job-card.transaction-status')[$this->transaction_status];
        }

        return ucfirst($transaction_status);

    }

    public function getActualManhourAttribute()
    {
        $job_card_statuses = config('ppc.job-card.transaction-status');
        $status_open = array_search('open', $job_card_statuses);
        $progresses_group = $this->progresses()->where('transaction_status', '<>', $status_open)->orderBy('created_at')->get()->groupBy('created_by');

        $total_manhours = 0;
        foreach ($progresses_group as $progresses) {
            foreach ($progresses as $key => $progress) {
                
                if( strlen($progress->transaction_status) == 36 ){
                    continue;
                }

                $code = $job_card_statuses[$progress->transaction_status];
                if ($code == "progress") {
                    $next_key = $key + 1;
                    $exists = array_key_exists($next_key, $progresses->toArray());

                    if ($exists) {
                        if (str_contains($job_card_statuses[$progresses[$next_key]->transaction_status], 'pending') || str_contains($job_card_statuses[$progresses[$next_key]->transaction_status],  'close')) {
                            $is_pending_close = true;
                        } else {
                            $is_pending_close = false;
                        }
                    }

                    if ($exists && $is_pending_close) {
                        $t1 = Carbon::parse($progress->created_at);
                        $t2 = Carbon::parse($progresses[$next_key]->created_at);
                        $diff = $t1->diffInSeconds($t2);
                        $total_manhours += $diff;
                    } else {
                        $t1 = Carbon::parse($progress->created_at);
                        $t2 = Carbon::now();
                        $diff = $t1->diffInSeconds($t2);
                        $total_manhours += $diff;
                    }
                }
            }
        }

        $actual_manhours = number_format(($total_manhours  / 3600), 2);


        return $actual_manhours;

    }

    public function getTaskcardAttribute(){
        if( is_object($this->taskcard_json) || is_array($this->taskcard_json) ){
            return $this->taskcard_json;
        }else{
            return json_decode($this->taskcard_json);
        }
    }

    public function getTaskcardGroupAttribute(){
        if( is_object($this->taskcard_group_json) || is_array($this->taskcard_group_json) ){
            return $this->taskcard_group_json;
        }else{
            return json_decode($this->taskcard_group_json);
        }
    }

    public function getTaskcardTypeAttribute(){
        if( is_object($this->taskcard_type_json) || is_array($this->taskcard_type_json) ){
            return $this->taskcard_type_json;
        }else{
            return json_decode($this->taskcard_type_json);
        }
    }

    public function getTaskcardWorkareaAttribute(){
        if( is_object($this->taskcard_workarea_json) || is_array($this->taskcard_workarea_json) ){
            return $this->taskcard_workarea_json;
        }else{
            return json_decode($this->taskcard_workarea_json);
        }
    }

    public function getAircraftTypesAttribute(){
        if( is_object($this->aircraft_types_json) || is_array($this->aircraft_types_json) ){
            return $this->aircraft_types_json;
        }else{
            return json_decode($this->aircraft_types_json);
        }
    }

    public function getAircraftTypeDetailsAttribute(){
        if( is_object($this->aircraft_type_details_json) || is_array($this->aircraft_type_details_json) ){
            return $this->aircraft_type_details_json;
        }else{
            return json_decode($this->aircraft_type_details_json);
        }
    }

    public function getAffectedItemsAttribute(){
        if( is_object($this->affected_items_json) || is_array($this->affected_items_json) ){
            return $this->affected_items_json;
        }else{
            return json_decode($this->affected_items_json);
        }
    }

    public function getAffectedItemDetailsAttribute(){
        if( is_object($this->affected_item_details_json) || is_array($this->affected_item_details_json) ){
            return $this->affected_item_details_json;
        }else{
            return json_decode($this->affected_item_details_json);
        }
    }

    public function getTagsAttribute(){
        if( is_object($this->tags_json) || is_array($this->tags_json) ){
            return $this->tags_json;
        }else{
            return json_decode($this->tags_json);
        }
    }

    public function getTagDetailsAttribute(){
        if( is_object($this->tag_details_json) || is_array($this->tag_details_json) ){
            return $this->tag_details_json;
        }else{
            return json_decode($this->tag_details_json);
        }
    }

    public function getAccessesAttribute(){
        if( is_object($this->accesses_json) || is_array($this->accesses_json) ){
            return $this->accesses_json;
        }else{
            return json_decode($this->accesses_json);
        }
    }

    public function getAccess_detailsAttribute(){
        if( is_object($this->access_details_json) || is_array($this->access_details_json) ){
            return $this->access_details_json;
        }else{
            return json_decode($this->access_details_json);
        }
    }

    public function getZonesAttribute(){
        if( is_object($this->zones_json) || is_array($this->zones_json) ){
            return $this->zones_json;
        }else{
            return json_decode($this->zones_json);
        }
    }

    public function getZoneDetailsAttribute(){
        if( is_object($this->zone_details_json) || is_array($this->zone_details_json) ){
            return $this->zone_details_json;
        }else{
            return json_decode($this->zone_details_json);
        }
    }

    public function getDocumentLibrariesAttribute(){
        if( is_object($this->document_libraries_json) || is_array($this->document_libraries_json) ){
            return $this->document_libraries_json;
        }else{
            return json_decode($this->document_libraries_json);
        }
    }

    public function getDocumentLibraryDetailsAttribute(){
        if( is_object($this->document_library_details_json) || is_array($this->document_library_details_json) ){
            return $this->document_library_details_json;
        }else{
            return json_decode($this->document_library_details_json);
        }
    }

    public function getAffectedManualsAttribute(){
        if( is_object($this->affected_manuals_json) || is_array($this->affected_manuals_json) ){
            return $this->affected_manuals_json;
        }else{
            return json_decode($this->affected_manuals_json);
        }
    }

    public function getAffectedManualDetailsAttribute(){
        if( is_object($this->affected_manual_details_json) || is_array($this->affected_manual_details_json) ){
            return $this->affected_manual_details_json;
        }else{
            return json_decode($this->affected_manual_details_json);
        }
    }

}
