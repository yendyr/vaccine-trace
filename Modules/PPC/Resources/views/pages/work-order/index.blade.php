@extends('layouts.master')

@section('content')
    @component('components.delete-modal', ['name' => 'Task Card Datalist'])
    @endcomponent

    @component('components.approve-modal', ['name' => 'Aircraft Configuration Datalist'])
    @endcomponent
    
    @include('ppc::pages.work-order.modal')

    @component('components.crud-form.index',[
                    'title' => 'Work Order Datalist',
                    'tableId' => 'work-order-table'])

        @slot('createButton')
            @can('create', Modules\PPC\Entities\WorkOrder::class)                
                <button type="button" id="create" class="btn btn-primary btn-lg">
                    <i class="fa fa-plus-circle"></i>&nbsp;Create New
                </button>   
            @endcan
        @endslot    

       
    @endcomponent

    @include('ppc::components.work-order._script')

@endsection

@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
    <style>
        thead input {
            width: 100%;
        }
        tr.group,
        tr.group:hover {
            background-color: #aaa !important;
        }
    </style>
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush