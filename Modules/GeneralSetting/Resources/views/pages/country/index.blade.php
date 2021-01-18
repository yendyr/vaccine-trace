@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Country Datalist'])
    @endcomponent

    @include('generalsetting::pages.country.modal')

    @component('components.crud-form.index',[
                    'title' => 'Country Datalist',
                    'tableId' => 'country-table'])

        @slot('createButton')
            @can('create', Modules\GeneralSetting\Entities\Country::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>ISO</th>
            <th>ISO-3</th>
            <th>Name</th>
            <th>Nice Name</th>
            <th>Num. Code</th>
            <th>Phone Code</th>
            <th>Description/Remark</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('generalsetting::components.country._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush