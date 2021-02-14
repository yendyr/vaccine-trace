@extends('layouts.master')

@push('header-scripts')
    <style>
        .select2-container.select2-container--default.select2-container--open {
            z-index: 9999999 !important;
        }
        .select2{
            width: 100% !important;
        }

        .selected{
            background-color: #f2f2f2;
        }

        div.DTFC_RightBodyLiner{
            background-color: white;
            overflow-y: hidden !important;
            top: -13px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" integrity="sha512-rxThY3LYIfYsVCWPCW9dB0k+e3RZB39f23ylUYTEuZMDrN/vRqLdaCBo/FbvVT6uC2r0ObfPzotsfKF9Qc5W5g==" crossorigin="anonymous" />
@endpush

@section('content')
    @component('components.delete-modal', ['name' => 'Leave Quota Datalist'])
    @endcomponent

    @include('humanresources::pages.leave-quota.modal')

    @component('components.crud-form.index',[
                    'title' => 'Leave Quota Datalist',
                    'tableId' => 'leave-quota-table'])

        @slot('createButton')
            @can('create', \Modules\HumanResources\Entities\LeaveQuota::class)
                <div id="form_result" role="alert"></div>
                <button type="button" id="create" class="btn btn-primary btn-lg"><i class="fa fa-plus-square"></i> New Leave Quota</button>
            @endcan
        @endslot

        @slot('tableContent')
            <th>Employee ID</th>
            <th>Quota Year</th>
            <th>Quota Code</th>
            <th>Quota start date</th>
            <th>Quota exp date</th>
            <th>Quota alloc date</th>
            <th>Quota quantity</th>
            <th>Quota remains</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Action</th>
        @endslot

    @endcomponent

    @include('humanresources::components.leave-quota._script')

@endsection
@push('header-scripts')
    @include('layouts.includes._header-datatable-script')
@endpush
@push('footer-scripts')
    @include('layouts.includes._footer-datatable-script')
@endpush
