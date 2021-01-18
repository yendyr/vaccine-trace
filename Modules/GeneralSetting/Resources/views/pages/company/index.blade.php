@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Company Datalist'])
    @endcomponent

    @include('generalsetting::pages.company.modal')

    @component('components.crud-form.index',[
                    'title' => 'Company Datalist',
                    'tableId' => 'company-table'])

        @slot('createButton')
            @can('create', Modules\GeneralSetting\Entities\Company::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Name</th>
            <th>GST Number</th>
            <th>NPWP</th>
            <th>Description/Remark</th>
            <th>As Customer</th>
            <th>As Supplier</th>
            <th>As Vendor</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>            
        @endslot
    @endcomponent

    @include('generalsetting::components.company._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush