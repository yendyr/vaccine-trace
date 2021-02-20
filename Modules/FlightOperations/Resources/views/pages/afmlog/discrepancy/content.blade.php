<div class="col fadeIn" style="animation-duration: 1.5s">
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalDiscrepancy',
                    'deleteFormId' => 'deleteFormDiscrepancy',
                    'deleteModalButtonId' => 'deleteModalButtonDiscrepancy'])

    @include('flightoperations::pages.afmlog.discrepancy.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Flight Discrepancy Datalist',
        'tableId' => 'afml-detail-discrepancy'])

    @if($afmlog->approvals()->count() == 0)
        @slot('createButton')
            @can('update', Modules\FlightOperations\Entities\AfmLog::class)                
                <button type="button" id="createButtonDiscrepancy" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Discrepancy
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>Code</th>
        <th>Title</th>
        <th>Description</th>
        <th>Related Rectification Performed</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('flightoperations::components.afmlog.discrepancy._script')