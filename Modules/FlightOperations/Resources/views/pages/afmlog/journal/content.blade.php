<div class="col fadeIn" style="animation-duration: 1.5s">
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalJournal',
                    'deleteFormId' => 'deleteFormJournal',
                    'deleteModalButtonId' => 'deleteModalButtonJournal'])

    @include('flightoperations::pages.afmlog.journal.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Flight Journal Datalist',
        'tableId' => 'afml-detail-journal'])

    @if($afmlog->approvals()->count() == 0)
        @slot('createButton')
            @can('update', Modules\FlightOperations\Entities\AfmLog::class)                
                <button type="button" id="createButtonJournal" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Journal
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>From</th>
        <th>To</th>
        <th>Block Off</th>
        <th>Take Off</th>
        <th>Landing</th>
        <th>Block On</th>
        <th>Total Flight Hour</th>
        <th>Total Block Hour</th>
        <th>Total Cycle</th>
        <th>Total Event</th>
        <th>Remark</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('flightoperations::components.afmlog.journal._script')