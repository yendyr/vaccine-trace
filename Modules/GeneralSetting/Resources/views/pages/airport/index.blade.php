@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Airport Datalist'])
    @endcomponent

    @include('generalsetting::pages.airport.modal')

    @component('components.crud-form.index',[
                    'title' => 'Airport Datalist',
                    'tableId' => 'airport-table'])

        @slot('createButton')
            @can('create', Modules\GeneralSetting\Entities\Airport::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Type</th>
            <th>Name</th>
            <th>Latitude</th>
            <th>Longitude</th>
            <th>Elevation</th>
            <th>Continent</th>
            <th>ISO Country</th>
            <th>ISO Region</th>
            <th>Municipality</th>
            <th>Scheduled Service</th>
            <th>GPS Code</th>
            <th>IATA Code</th>
            <th>Local Code</th>           
            <th>Description</th>            
            <th>Status</th>            
            <th>Created By</th>            
            <th>Created At</th>            
            <th>Last Updated By</th>            
            <th>Last Updated At</th>            
            <th>Action</th>            
        @endslot
    @endcomponent

    @include('generalsetting::components.airport._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush