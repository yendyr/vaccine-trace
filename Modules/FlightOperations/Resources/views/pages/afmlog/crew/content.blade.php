<div class="col fadeIn" style="animation-duration: 1.5s">
    @component('components.delete-modal', ['name' => 'Flight Crew Datalist'])
    @endcomponent

    @include('flightoperations::pages.afml.crew.modal')
    
    @component('components.crud-form.index',[
        'title' => 'Flight Crew Datalist',
        'tableId' => 'crew-detail'])

    @if($afml->approvals()->count() == 0)
        @slot('createButton')
            @can('update', Modules\FlightOperations\Entities\AircraftFlightMaintenanceLog::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Add Crew
                </button>   
            @endcan
        @endslot    
    @endif

    @slot('tableContent')
        <th>Person Name</th>
        <th>In-Flight Role</th>
        <th>Description/Remark</th>
        <th>Status</th>
        <th>Created By</th>
        <th>Created At</th>
        <th>Action</th>
    @endslot
    @endcomponent
</div>

@include('flightoperations::components.afml.crew._script')