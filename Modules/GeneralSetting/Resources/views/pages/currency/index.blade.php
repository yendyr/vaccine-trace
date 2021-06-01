@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Currency Datalist'])
    @endcomponent

    @include('generalsetting::pages.currency.modal')

    @component('components.crud-form.index',[
                    'title' => 'Currency Datalist',
                    'tableId' => 'currency-table'])

        @slot('createButton')
            @can('create', Modules\GeneralSetting\Entities\Currency::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

        @slot('tableContent')
            <th>Code</th>
            <th>Symbol</th>
            <th>Name</th>
            <th>Description/Remark</th>
            <th>Country</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Created At</th>
            <th>Last Updated By</th>
            <th>Last Updated At</th>
            <th>Action</th>
        @endslot
    @endcomponent

    @include('generalsetting::components.currency._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush