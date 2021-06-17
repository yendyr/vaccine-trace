@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-9">
        @component('components.delete-modal', ['name' => 'Chart of Account Datalist'])
        @endcomponent

        @include('accounting::pages.chart-of-account.modal')

        @component('components.crud-form.index',[
                        'title' => 'Chart of Account Datalist',
                        'tableId' => 'chart-of-account-table'])

            @slot('createButton')
                @can('create', Modules\Accounting\Entities\ChartOfAccount::class)                
                    <button type="button" id="create" class="btn btn-primary btn-lg">
                        <i class="fa fa-plus-circle"></i>&nbsp;Create New
                    </button>   
                @endcan
            @endslot    

            @slot('tableContent')
                <th>Code</th>
                <th>Name</th>
                <th>Parent Group Name</th>
                <th>Class</th>
                <th>Position</th>
                <th>Description/Remark</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created At</th>
                {{-- <th>Last Updated By</th>
                <th>Last Updated At</th> --}}
                <th>Action</th>
            @endslot
        @endcomponent

        @include('accounting::components.chart-of-account._script')
    </div>

    <div class="col-lg-3">        
        <span style="font-size: 18px; font-weight: 200;">Current Grouping Structure Tree</span><br>
        <span style="font-weight: 200;">
            <i class="fa fa-info-circle"></i>
            <i>Refresh Page to Update View</i>
        </span>
        <br><br>
        
        <div id="tree_view">

        </div>             
    </div>
</div>
@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    @include('accounting::components.chart-of-account._tree-script')
    <link href="{{ URL::asset('theme/css/plugins/jsTree/proton/style.min.css') }}" rel="stylesheet">
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush