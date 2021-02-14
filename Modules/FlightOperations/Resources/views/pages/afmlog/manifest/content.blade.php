<div class="col fadeIn" style="animation-duration: 1.5s">
    @include('components.delete-modal', 
                    ['deleteModalId' => 'deleteModalManifest',
                    'deleteFormId' => 'deleteFormManifest',
                    'deleteModalButtonId' => 'deleteModalButtonManifest'])

    @include('flightoperations::pages.afmlog.manifest.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Flight Manifest Datalist',
        'tableId' => 'afml-detail-manifest'])

    @if($afmlog->approvals()->count() == 0)
        @slot('createButton')
            @can('update', Modules\FlightOperations\Entities\AfmLog::class)                
                <button type="button" id="createButtonManifest" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Manifest
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>Person</th>
        <th>Pax</th>
        <th>Cargo Weight</th>
        <th>Cargo Weight Unit</th>
        <th>PCM Number</th>
        <th>CM Number</th>
        <th>Remark</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('flightoperations::components.afmlog.manifest._script')