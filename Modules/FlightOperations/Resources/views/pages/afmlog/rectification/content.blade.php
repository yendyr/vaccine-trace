<div class="col fadeIn" style="animation-duration: 1.5s">
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalRectification',
                    'deleteFormId' => 'deleteFormRectification',
                    'deleteModalButtonId' => 'deleteModalButtonRectification'])

    @include('flightoperations::pages.afmlog.rectification.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Flight Rectification Datalist',
        'tableId' => 'afml-detail-rectification'])

    @if($afmlog->approvals()->count() == 0)
        @slot('createButton')
            @can('update', Modules\FlightOperations\Entities\AfmLog::class)                
                <button type="button" id="createButtonRectification" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Rectification
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>Code</th>
        <th>Discrepancy Reference</th>
        <th>Title</th>
        <th>Description</th>
        <th>Performed by</th>
        {{-- <th>Progress Status</th> --}}
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('flightoperations::components.afmlog.rectification._script')